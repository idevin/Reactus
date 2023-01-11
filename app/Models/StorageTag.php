<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\StorageTag
 *
 * @property integer $id
 * @property integer $parent_id
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property string $name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property integer $user_id
 * @property-read Collection|\App\Models\StorageFile[] $files
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StorageTag whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StorageTag whereParentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StorageTag whereLft($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StorageTag whereRgt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StorageTag whereDepth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StorageTag whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StorageTag whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StorageTag byUser()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StorageTag whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StorageTag whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StorageTag whereUserId($value)
 * @mixin Eloquent
 * @method static Builder|\App\Models\StorageTag newModelQuery()
 * @method static Builder|\App\Models\StorageTag newQuery()
 * @method static Builder|\App\Models\StorageTag query()
 * @property-read int|null $files_count
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Query\Builder|StorageTag onlyTrashed()
 * @method static Builder|StorageTag whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|StorageTag withTrashed()
 * @method static \Illuminate\Database\Query\Builder|StorageTag withoutTrashed()
 */
class StorageTag extends Model
{
    use SoftDeletes;

    protected $table = 'storage_tag';
    protected $fillable = ['name', 'user_id', 'slug'];

    protected $appends = ['files_count'];

    protected $hidden = ['created_at', 'updated_at', 'files', 'user_id', 'slug', 'pivot', 'deleted_at'];

    public static function slug(string $name)
    {
        return slugify($name, false, '_');
    }

    public function files()
    {
        return $this->belongsToMany(StorageFile::class, 'storage_file_tag', 'storage_tag_id', 'storage_file_id');
    }

    public function getFilesCountAttribute()
    {
        return $this->files->count();
    }

    public function scopeByUser($query) {
        return $query->whereUserId(Auth::user()->id);
    }
}
