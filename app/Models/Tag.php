<?php

namespace App\Models;

use Conner\Tagging\Model\Tag as TagModel;
use Conner\Tagging\Model\TagGroup;
use Conner\Tagging\TaggingUtility;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Tag
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property int $suggest
 * @property int $count
 * @property Carbon|null $deleted_at
 * @property int $disabled
 * @property-read TagGroup $group
 * @method static Builder|Tag inGroup($groupName)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newQuery()
 * @method static Builder|Tag onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag query()
 * @method static Builder|Tag suggested()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereDisabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereSuggest($value)
 * @method static Builder|Tag withTrashed()
 * @method static Builder|Tag withoutTrashed()
 * @mixin \Eloquent
 */
class Tag extends TagModel
{
    public $timestamps = false;
    public $fillable = ['name', 'disabled'];
    protected $table = 'tagging_tags';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * @param $type
     * @return mixed
     */
    public static function relatedTags($type): mixed
    {
        $model = TaggingUtility::taggedModelString();

        return $model::query()->distinct()->join('tagging_tags', 'tag_slug', '=', 'tagging_tags.slug')
            ->join('storage_file', 'storage_file.id', '=', 'tagging_tagged.taggable_id')
            ->where('taggable_type', $type)
            ->where('storage_file.user_id', Auth::user()->id)
            ->orderBy('tag_slug', 'ASC')
            ->whereNull('tagging_tags.deleted_at')
            ->get(['tagging_tags.id', 'tag_name as name', 'tagging_tags.count as count']);
    }

    public static function reindex($tags, string $method = '+', bool $deleteTag = false)
    {

        $methods = [
            '+' => 'decrementCount',
            '-' => 'incrementCount'
        ];

        if (in_array($method, array_keys($methods)) && count($tags) > 0) {
            foreach ($tags as $tag) {
                if ($tag) {
                    TaggingUtility::{$methods[$method]}($tag->name, $tag->slug, 1);

                    if ($deleteTag == true) {
                        TaggingUtility::deleteUnusedTags();
                    }

                    $tag->refresh();

                    if ($tag->count <= 0) {
                        $tag->update([
                            'count' => 0
                        ]);
                    }
                }
            }
        }
    }

    public function setDisabled($value)
    {

    }

    public static function filterTags(){

    }
}