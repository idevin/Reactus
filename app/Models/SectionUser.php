<?php

namespace App\Models;

use Baum\Extensions\Eloquent\Collection;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\SectionUser
 *
 * @property int $id
 * @property int $user_id
 * @property int $section_id
 * @property-read \App\Models\Section $section
 * @property-read Collection|\App\Models\Section[] $sections
 * @property-read \App\Models\User $user
 * @method static Builder|\App\Models\SectionUser newModelQuery()
 * @method static Builder|\App\Models\SectionUser newQuery()
 * @method static Builder|\App\Models\SectionUser query()
 * @method static Builder|\App\Models\SectionUser whereId($value)
 * @method static Builder|\App\Models\SectionUser whereSectionId($value)
 * @method static Builder|\App\Models\SectionUser whereUserId($value)
 * @mixin Eloquent
 * @property-read int|null $sections_count
 */
class SectionUser extends Model
{
    public $timestamps = false;
    protected $table = 'section_user';
    protected $fillable = ['user_id', 'section_id', 'deleted_at'];
    protected $connection = 'mysql';

    public function user()
    {
        $this->setConnection('mysqlu');
        return $this->belongsTo(User::class);
    }

    public function section()
    {
        $this->setConnection('mysql');
        return $this->belongsTo(Section::class)->withTrashed();
    }

    public function sections()
    {
        $this->setConnection('mysql');
        return $this->hasMany(Section::class, 'id', 'section_id');
    }

    public function roles()
    {
        $this->setConnection('mysql');
        return SectionRole::where('section_id', $this->section_id)->where('user_id', $this->user_id);
    }
}