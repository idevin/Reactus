<?php


namespace App\Traits;


use App\Models\StorageFile;
use Auth;
use Conner\Tagging\TaggingUtility;
use finfo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Filesystem\Filesystem;
use Validator;

trait Storage
{
    public static function validateChunk($data, $except = [], $customErrors = [], $customMessages = [])
    {
        $objectTypes = implode(',', StorageFile::objectTypes);

        $default = [
            'fileName' => 'required',
            'totalSize' => 'required',
            'data' => 'required',
            'chunkPositionStart' => 'required',
            'chunkPositionEnd' => 'required',
            'objectType' => 'required|in:' . $objectTypes
        ];

        $messages = [
            'objectType.required' => 'Не задан тип обьекта',
            'objectType.in' => 'Неверный тип обьекта (' . $objectTypes . ')',
            'fileName.required' => 'Не задано имя файла',
            'totalSize.required' => 'Не задан размер файла',
            'data.required' => 'Нет бинарных данных',
            'chunkPositionStart.required' => 'Не задано начало части',
            'chunkPositionEnd.required' => 'Не задан конец части'
        ];

        return Utils::makeValidator($data, $messages, $customMessages, $default, $customErrors, $except);
    }

    public static function saveChunkedFile($uploadId, $extension, $totalSize, $objectType, $fileName, $extraData, $tags)
    {

        $fs = new Filesystem();
        $files = $fs->glob('/tmp/c_' . $uploadId . '*');

        $user = Auth::user();

        $hash = generate_code(16, true);

        $newFilename = $hash . '.' . $extension;

        $defaultPath = StorageFile::STORAGE_PATH . $user->id . DS . $hash[0] .
            $hash[1] . DS . $hash[2] . $hash[3] . DS . $hash[4] . DS;

        $path = $defaultPath . $extension . DS;

        $root = Media::getImageRoot();

        $fs->makeDirectory($root . DS . $path, 0755, true);

        $cmd = 'cat ';

        for ($i = 1; $i < count($files) + 1; $i++) {
            $blobFile = '/tmp/c_' . $uploadId . '.' . $i;
            $cmd .= $blobFile . ' ';
        }

        $fullPath = $root . DS . $path . $newFilename;

        $cmd .= ' >> ' . $fullPath;

        exec("nohup $cmd /dev/null 2>&1 &", $out, $resultCode);

        if ($out != "") {
            debugvars($out);
        }

        $mimeType = (new finfo(FILEINFO_MIME_TYPE))->file($fullPath);

        $url = getSchema() . $user->domain . $path . $newFilename;

        $storageFileData = [
            'user_id' => $user->id,
            'filename' => $newFilename,
            'type' => $mimeType,
            'size' => $totalSize,
            'hash' => $hash,
            'extension' => $extension,
            'url' => $url,
            'path' => $fullPath,
            'object_type' => $objectType,
            'original_filename' => $fileName
        ];

        $object = (new StorageFile())->create($storageFileData);

        $allData['uploaded'] = 1;
        $allData['object'] = $object;

        if (!empty($extraData)) {
            $allData += $extraData;
        }

        $tags = TaggingUtility::makeTagArray($tags);

        $object->tag($tags);

        Media::call()->createThumbs($fullPath, config('image.thumb.storage'), 'storage', null, $user);

        return $allData;
    }

    public static function makeQuery($data, $recycled): Builder
    {
        $objects = StorageFile::query();

        if ($recycled) {
            $objects = $objects->onlyTrashed();
        }

        $objects = $objects->select('storage_file.*')->where('storage_file.user_id', Auth::user()->id);

        if (isset($data['field']) && isset($data['order']) &&
            in_array($data['field'], array_keys(StorageFile::sort)) &&
            in_array($data['order'], array_keys(StorageFile::order))) {
            $field = 'storage_file.' . StorageFile::sort[$data['field']];
            $order = StorageFile::order[$data['order']];
        } else {
            $field = 'storage_file.' . StorageFile::sort[5];
            $order = StorageFile::order[0];
        }

        if (isset($data['term'])) {
            $term = Utils::cleanChars($data['term']);

            $objects = $objects->where(function ($query) use ($term) {
                $query->orWhere('title', 'LIKE', '%' . $term . '%')
                    ->orWhere('description', 'LIKE', '%' . $term . '%')
                    ->orWhere('filename', 'LIKE', '%' . $term . '%')
                    ->orWhere('original_filename', 'LIKE', '%' . $term . '%')
                    ->orWhere('url', 'LIKE', '%' . $term . '%');
            });
        }

        if (isset($data['objectType'])) {
            $objectTypes = json_decode($data['objectType'], true);
            if ($objectTypes) {
                $objects = $objects->whereIn('object_type', array_values($objectTypes));
            }
        }

        if (isset($data['favorite'])) {
            $objects = $objects->whereFavorite((int)$data['favorite']);
        }

        $objects = $objects->orderBy($field, $order);

        return $objects->groupBy(['storage_file.id']);
    }
}