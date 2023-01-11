<?php

namespace App\Models;

use Baum\Node;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\ComplainOption
 *
 * @property int $id
 * @property int|null $parent_id
 * @property int|null $lft
 * @property int|null $rgt
 * @property int|null $depth
 * @property string $title
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $value
 * @property-read \Baum\Extensions\Eloquent\Collection|\App\Models\ComplainOption[] $children
 * @property-read Collection|\App\Models\Complain[] $complains
 * @property-read \App\Models\ComplainOption|null $parent
 * @method static Builder|\Baum\Node limitDepth($limit)
 * @method static Builder|\App\Models\ComplainOption whereCreatedAt($value)
 * @method static Builder|\App\Models\ComplainOption whereDepth($value)
 * @method static Builder|\App\Models\ComplainOption whereId($value)
 * @method static Builder|\App\Models\ComplainOption whereLft($value)
 * @method static Builder|\App\Models\ComplainOption whereParentId($value)
 * @method static Builder|\App\Models\ComplainOption whereRgt($value)
 * @method static Builder|\App\Models\ComplainOption whereTitle($value)
 * @method static Builder|\App\Models\ComplainOption whereUpdatedAt($value)
 * @method static Builder|\App\Models\ComplainOption whereValue($value)
 * @method static Builder|\Baum\Node withoutNode($node)
 * @method static Builder|\Baum\Node withoutRoot()
 * @method static Builder|\Baum\Node withoutSelf()
 * @mixin Eloquent
 * @method static Builder|\App\Models\ComplainOption newModelQuery()
 * @method static Builder|\App\Models\ComplainOption newQuery()
 * @method static Builder|\App\Models\ComplainOption query()
 * @property-read int|null $children_count
 * @property-read int|null $complains_count
 * @method static \Baum\Extensions\Eloquent\Collection|static[] all($columns = ['*'])
 * @method static \Baum\Extensions\Eloquent\Collection|static[] get($columns = ['*'])
 */
class ComplainOption extends Node
{
    public $timestamps = true;


    protected $table = 'complain_option';
    protected $fillable = ['title', 'id', 'value', 'parent_id'];

    public static function getTree()
    {
        $complainOptionsArray = [];

        $complainOptionRoot = ComplainOption::root();

        if ($complainOptionRoot) {
            $complainOptions = ComplainOption::root()->getDescendantsAndSelf(array('*'), 3)->toHierarchy();

            $i = 0;

            foreach ($complainOptions as &$complainOption) {
                $i += 1;
                $j = 0;
                $complainOption->title = '  ' . $i . ' ' . $complainOption->title;
                $complainOptionsArray[$complainOption->id] = $complainOption;
                if (!empty($complainOption['children'])) {
                    $complainOptionsArray = self::recursive($complainOptionsArray, $complainOption['children'], $i, $j);
                }
            }
        }

        return $complainOptionsArray;
    }

    public static function recursive(&$complainOptionsArray, $children, ...$args)
    {
        if (!empty($children)) {
            $newArg = 0;

            foreach ($children as $child) {
                $newArg += 1;
                $argsString = implode('.', $args);

                if ($child->depth >= 3) {
                    $argsString .= '.' . $newArg . ' ';
                    if (empty($child['children'])) {
                        $args[count($args) - 1] = $newArg;

                    }

                } else {
                    $args[count($args) - 1] = $args[count($args) - 1] + 1;
                    $argsString = implode('.', $args);
                }

                $child->title = str_repeat(' &nbsp; ', $child->depth) . $argsString . ' ' . $child->title;
                $complainOptionsArray[$child->id] = $child;

                if (!empty($child['children'])) {
                    $complainOptionsArray = self::recursive($complainOptionsArray, $child['children'], ...$args);
                }
            }
        }

        return $complainOptionsArray;
    }

    public static function getTreeOptions($node = null, $withEmptyValue = false, $withRoot = true): array
    {
        if (!$node) {
            $node = static::root();
        }

        $options = $withEmptyValue ? ['' => 'Выберите...'] : [];
        $nodes = $withRoot ? $node->getDescendantsAndSelf() : $node->getDescendants();
        foreach ($nodes->toArray() as $item) {
            $options[$item['id']] = sprintf('%s %s',
                str_repeat('&nbsp;', abs($item['depth'] * 3 - 1)) .
                str_repeat('&#8735;', round($item['depth'] / ($item['depth'] + 0.9))),
                $item['title']
            );
        }

        return $options;
    }

    public function complains(): HasMany
    {
        return $this->hasMany(Complain::class);
    }
}