<?php

namespace App\Models;


use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\LanguageObjectGroup
 *
 * @property int $id
 * @property int|null $language_id
 * @property int|null $language_object_id
 * @property int $mapped_id
 * @property-read \App\Models\LanguageObject|null $languageObject
 * @property-read \App\Models\Language $lanugage
 * @method static Builder|\App\Models\LanguageObjectGroup newModelQuery()
 * @method static Builder|\App\Models\LanguageObjectGroup newQuery()
 * @method static Builder|\App\Models\LanguageObjectGroup query()
 * @method static Builder|\App\Models\LanguageObjectGroup whereId($value)
 * @method static Builder|\App\Models\LanguageObjectGroup whereLanguageId($value)
 * @method static Builder|\App\Models\LanguageObjectGroup whereLanguageObjectId($value)
 * @method static Builder|\App\Models\LanguageObjectGroup whereMappedId($value)
 * @mixin Eloquent
 */
class LanguageObjectGroup extends Model
{
    public $timestamps = false;
    protected $table = 'language_object_group';
    protected $fillable = ['language_id', 'language_object_id', 'mapped_id'];

    public function lanugage()
    {
        return $this->belongsTo(Language::class);
    }

    public function languageObject()
    {
        return $this->belongsTo(LanguageObject::class);
    }
}
