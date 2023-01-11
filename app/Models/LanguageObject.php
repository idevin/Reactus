<?php

namespace App\Models;


use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Models\LanguageObject
 *
 * @property int $id
 * @property int $object_id
 * @property string $object_type
 * @property int $language_id
 * @property string $link
 * @property string $title
 * @property-read \App\Models\Language $language
 * @property-read Collection|\App\Models\LanguageObjectGroup[] $languageObjectGroups
 * @property-read \Illuminate\Database\Eloquent\Model|Eloquent $object
 * @method static Builder|\App\Models\LanguageObject newModelQuery()
 * @method static Builder|\App\Models\LanguageObject newQuery()
 * @method static Builder|\App\Models\LanguageObject query()
 * @method static Builder|\App\Models\LanguageObject whereId($value)
 * @method static Builder|\App\Models\LanguageObject whereLanguageId($value)
 * @method static Builder|\App\Models\LanguageObject whereLink($value)
 * @method static Builder|\App\Models\LanguageObject whereObjectId($value)
 * @method static Builder|\App\Models\LanguageObject whereObjectType($value)
 * @method static Builder|\App\Models\LanguageObject whereTitle($value)
 * @mixin Eloquent
 * @property-read int|null $language_object_groups_count
 */
class LanguageObject extends Model
{
    public $timestamps = false;
    protected $table = 'language_object';
    protected $fillable = ['object_id', 'object_type', 'link', 'title', 'language_id'];

    public function object()
    {
        return $this->morphTo();
    }

    public function languageObjectGroups()
    {
        return $this->hasMany(LanguageObjectGroup::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
