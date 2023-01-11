<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\BlogSectionUser
 *
 * @property int $id
 * @property int $user_id
 * @property int $section_id
 * @property-read \App\Models\BlogSection $section
 * @property-read \App\Models\User $user
 * @method static Builder|\App\Models\BlogSectionUser whereId($value)
 * @method static Builder|\App\Models\BlogSectionUser whereSectionId($value)
 * @method static Builder|\App\Models\BlogSectionUser whereUserId($value)
 * @mixin Eloquent
 * @method static Builder|\App\Models\BlogSectionUser newModelQuery()
 * @method static Builder|\App\Models\BlogSectionUser newQuery()
 * @method static Builder|\App\Models\BlogSectionUser query()
 */
class BlogSectionUser extends Model
{
    public $timestamps = false;
    protected $table = 'blog_section_user';
    protected $fillable = ['user_id', 'section_id'];
    protected $connection = 'mysql';


    public function user()
    {
        $this->setConnection('mysqlu');
        return $this->belongsTo(User::class);
    }

    public function section()
    {
        $this->setConnection('mysql');
        return $this->belongsTo(BlogSection::class, 'section_id');
    }

    public function roles()
    {
        $this->setConnection('mysql');
        return SectionRole::where('section_id', $this->section_id)->where('user_id', $this->user_id);
    }
}