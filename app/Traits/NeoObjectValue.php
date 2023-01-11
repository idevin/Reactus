<?php

namespace App\Traits;

use App\Models\StorageFile;
use Illuminate\Filesystem\Filesystem;

trait NeoObjectValue
{
    public function getValue0($value, $object = null): string
    {
        if (empty($value)) {
            return '';
        }
        return $value;
    }

    public function getValue1($value, $object = null): int
    {
        return (int)$value;
    }

    public function getValue2($value, $object = null): string
    {
        if (empty($value)) {
            return '';
        }
        return $value;
    }

    public function getValue3($value, $object = null): string
    {
        if (empty($value)) {
            return '';
        }
        return $value;
    }

    public function getValue4($value, $object = null): string
    {
        if (empty($value)) {
            return '';
        }
        return $value;
    }

    public function getValue5($value, $object = null)
    {

        if (!empty($value) && !empty($value['name']) && !empty($value['base64'])) {
            $tmp = sys_get_temp_dir();
            $nameArray = pathinfo($value['name']);
            $name = slugify($nameArray['filename'], false);
            $extensionName = !isset($nameArray['extension']) ? '.ext' : '.' . $nameArray['extension'];
            list($params, $base64) = preg_split("#\,#", $value['base64']);
            preg_match("#(.*)\:(.*);(.*)#", $params, $paramsMatches);

            $fileContents = base64_decode($base64);

            $fs = new Filesystem();
            $tmpPathname = $tmp . DS . $name . $extensionName;

            $fs->put($tmpPathname, $fileContents);
            $file = new \SplFileInfo($tmpPathname);
            $data = null;

            if ($file && $file->isFile()) {
                $hash = generate_code(16, true);
                $extension = strtolower($file->getExtension());

                $newFilename = $hash . '.' . $extension;

                $path = StorageFile::STORAGE_PATH . \Auth::user()->id . DS . $hash[0] . $hash[1] . DS .
                    $hash[2] . $hash[3] . DS . $hash[4] . DS . $extension . DS;

                $data = [
                    'user_id' => \Auth::user()->id,
                    'filename' => pathinfo($file->getFilename())['filename'],
                    'type' => $paramsMatches[2],
                    'size' => $file->getSize(),
                    'hash' => $hash,
                    'extension' => $extension,
                    'url' => $path,
                    'path' => getenv('DOCUMENT_ROOT') . DS . $path . $newFilename
                ];

                StorageFile::firstOrCreate($data);

                $fs->makeDirectory(getenv('DOCUMENT_ROOT') . DS . $path, 0755, true);
                $fs->move($tmpPathname, getenv('DOCUMENT_ROOT') . DS . $path . DS . $newFilename);
            }

            return json_encode($data);
        }

        if (empty($value)) {
            return json_encode('');
        }
        return json_encode($value);
    }

    public function getValue6($value, $object = null)
    {
        if (empty($value)) {
            return 0;
        }
        return $value;
    }

    public function getValue7($value, $object = null)
    {
        if (!empty($value)) {
            return $object->setNeoBigData($value);
        }

        return null;
    }

    public function getValue8($value, $object = null)
    {
        if (empty($value)) {
            return '';
        }
        return $value;
    }

    public function getValue9($value, $object = null)
    {
        if (empty($value)) {
            return '';
        }
        return $value;
    }

    public function getValue10($value, $object = null)
    {
        if (empty($value)) {
            return null;
        }
        return json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
    }

    public function getValue11($value, $object = null)
    {
        if (empty($value)) {
            return null;
        }

        return $value;
    }

    public function getValue13($value, $object = null)
    {
        if (empty($value)) {
            return null;
        }
        return $value;
    }

    public function getValue14($value, $object = null)
    {
        if (empty($value)) {
            return null;
        }

        return saveNeoDataFile($value, $object->id);
    }

    public function getValue15($value)
    {
        if (!empty($value)) {
            return json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
        }

        return null;
    }

    public function getValue18($value)
    {
        if (!empty($value)) {
            return json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
        }

        return null;
    }

    public function getValue16($value, $object = null)
    {
        return $value;
    }

    public function getValue17($value, $object = null)
    {
        return $value;
    }

    public function getValue19($value, $object = null)
    {
        return $this->getValue12($value, $object);
    }

    public function getValue12($value, $object = null)
    {
        if (!empty($value)) {
            return $object->setNeoBigData($value);
        }

        return null;
    }

    public function getValue20($value, $object = null)
    {
        return $value;
    }

    public function createQl1($checkboxValue, $index)
    {
        return 'f' . $index . '.value=' . (int)$checkboxValue;
    }

    public function createQl6($value, $index)
    {
        $fieldTerm = $value[0];
        $fieldTerm2 = $value[1];
        $commonClause = 'f' . $index . '.value >=' . $fieldTerm . ' AND ';
        $commonClause .= 'f' . $index . '.value <=' . $fieldTerm2;

        return $commonClause;
    }

    public function createQl11($value, $index)
    {
        $fieldTerm = (int)$value[0];
        $fieldTerm2 = (int)$value[1];

        if ($fieldTerm != 0 && $fieldTerm2 != 0) {
            if ($fieldTerm > $fieldTerm2) {
                $number = $fieldTerm2;
                $number2 = $fieldTerm;
            } else {
                $number = $fieldTerm;
                $number2 = $fieldTerm2;
            }
        } else {
            $number = $fieldTerm;
            $number2 = $fieldTerm2;
        }


        if ($number == 0 && $number2 == 0) {
            return null;
        } else {
            if ($number == 0) {
                $commonClause = 'f' . $index . '.value <=' . $number2;
            } elseif ($number2 == 0) {
                $commonClause = 'f' . $index . '.value >=' . $number;
            } else {
                $commonClause = 'f' . $index . '.value >=' . $number . ' AND ';
                $commonClause .= 'f' . $index . '.value <=' . $number2;
            }
        }

        return $commonClause;
    }

    public function createQl2($value, $index)
    {
        return "f" . $index . ".value=~'(?iu).*{$value}.*'";
    }

    public function createQl10($value, $index)
    {
        $string = '';

        foreach ($value as $i => $v) {
            $string .= "f" . $index . ".value=~'(?iu).*{$v}.*'";
            if ($i + 1 != count($value)) {
                $string .= ' OR ';
            }
        }

        return $string;
    }

    public function createQl9($value, $index)
    {
        $fieldTerm0 = isset($value[0]) ? date('Y-m-d', strtotime($value[0])) : null;
        $fieldTerm1 = isset($value[1]) ? date('Y-m-d', strtotime($value[1])) : null;

        $commonClause = '';

        switch ($value) {
            case isset($value[0]) && isset($value[1]):
                $commonClause = 'f' . $index . '.value >="' . $fieldTerm0 . '"';
                $commonClause .= ' AND f' . $index . '.value <="' . $fieldTerm1 . '"';
                break;
            case isset($value[0]) && !isset($value[1]):
                $commonClause = 'f' . $index . '.value >="' . $fieldTerm0 . '"';
                break;
            case !isset($value[0]) && isset($value[1]):
                $commonClause = 'f' . $index . '.value <="' . $fieldTerm1 . '"';
                break;
        }

        return $commonClause;
    }
}