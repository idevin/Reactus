<?php

namespace App\Models;

use Conner\Tagging\Model\Tagged as TaggedModel;

/**
 * App\Models\Tagged
 *
 * @property int $id
 * @property int $taggable_id
 * @property string $taggable_type
 * @property string $tag_name
 * @property string $tag_slug
 * @property-read \Conner\Tagging\Model\Tag $tag
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $taggable
 * @method static \Illuminate\Database\Eloquent\Builder|Tagged newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tagged newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tagged query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tagged whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tagged whereTagName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tagged whereTagSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tagged whereTaggableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tagged whereTaggableType($value)
 * @mixin \Eloquent
 */
class Tagged extends TaggedModel
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }
}