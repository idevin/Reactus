<?php

namespace App\Models;

/**
 * App\Models\StorageFileTag
 *
 * @property int $id
 * @property int|null $storage_file_id
 * @property int|null $storage_tag_id
 * @property-read \App\Models\StorageFile $file
 * @property-read \App\Models\StorageTag $tag
 * @method static \Illuminate\Database\Eloquent\Builder|StorageFileTag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StorageFileTag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StorageFileTag query()
 * @method static \Illuminate\Database\Eloquent\Builder|StorageFileTag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StorageFileTag whereStorageFileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StorageFileTag whereStorageTagId($value)
 * @mixin \Eloquent
 */
class StorageFileTag extends Model
{
    protected $table = 'storage_file_tag';

    public $timestamps = false;

    protected $fillable = ['storage_file_id', 'storage_tag_id'];


    public function file()
    {
        return $this->belongsTo(StorageFile::class);
    }

    public function tag()
    {
        return $this->belongsTo(StorageTag::class);
    }
}
