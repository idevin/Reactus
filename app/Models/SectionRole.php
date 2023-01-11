<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\SectionRole
 *
 * @property integer $id
 * @property integer $role_id
 * @property integer $user_id
 * @property integer $section_id
 * @property-read \App\Models\Role $role
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Section $section
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SectionRole whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SectionRole whereRoleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SectionRole whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SectionRole whereSectionId($value)
 * @mixin Eloquent
 * @method static Builder|\App\Models\SectionRole newModelQuery()
 * @method static Builder|\App\Models\SectionRole newQuery()
 * @method static Builder|\App\Models\SectionRole query()
 */
class SectionRole extends Model
{
    public $timestamps = false;
    protected $table = 'section_role';
    protected $fillable = ['role_id', 'user_id', 'section_id'];

    public function role()
    {
        $this->setConnection('mysqlu');
        return $this->belongsTo(Role::class);
    }

    public function user()
    {
        $this->setConnection('mysqlu');
        return $this->belongsTo(User::class);
    }

    public function section()
    {
        $this->setConnection('mysql');
        return $this->belongsTo(Section::class);
    }
}