<?php

namespace App\Models;

use App\Traits\Media;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Watson\Rememberable\Rememberable;

/**
 * App\Models\UserStorageImage
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $storage_file_id
 * @property string|null $deleted_at
 * @property int $type
 * @property-read \App\Models\StorageFile|null $storageFile
 * @property-read \App\Models\User $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserStorageImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserStorageImage newQuery()
 * @method static Builder|\App\Models\UserStorageImage onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserStorageImage query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserStorageImage whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserStorageImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserStorageImage whereStorageFileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserStorageImage whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserStorageImage whereUserId($value)
 * @method static Builder|\App\Models\UserStorageImage withTrashed()
 * @method static Builder|\App\Models\UserStorageImage withoutTrashed()
 * @mixin Eloquent
 * @property-read mixed $image_url
 * @property mixed $images
 * @property-read mixed $thumbs
 */
class UserStorageImage extends Model
{
    use Media;
    use SoftDeletes;
    use Rememberable;

    const IMAGE = 0;
    const BACKGROUND = 1;
    const SLIDE = 2;
    public $timestamps = false;
    public string $rememberCacheTag = self::class;
    protected $connection = 'mysqlu';

    protected $table = 'user_storage_image';
    protected $fillable = ['user_id', 'storage_file_id', 'type'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function storageFile()
    {
        $this->setConnection('mysql');
        return $this->belongsTo(StorageFile::class)->withTrashed();
    }
}
