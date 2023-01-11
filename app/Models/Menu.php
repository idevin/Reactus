<?php

namespace App\Models;

use App\Traits\Media;
use Baum\Node;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use function Exception;

/**
 * App\Models\Menu
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string $title
 * @property string $url
 * @property int|null $site_id
 * @property int $position
 * @property int $in_hover_block
 * @property int $as_tree
 * @property string $alias
 * @property string|null $image
 * @property-read Site|null $site
 * @method static Builder|Menu bySite($site_id)
 * @method static Builder|Menu sorted()
 * @method static Builder|Menu whereAlias($value)
 * @method static Builder|Menu whereAsTree($value)
 * @method static Builder|Menu whereCreatedAt($value)
 * @method static Builder|Menu whereDeletedAt($value)
 * @method static Builder|Menu whereId($value)
 * @method static Builder|Menu whereImage($value)
 * @method static Builder|Menu whereInHoverBlock($value)
 * @method static Builder|Menu wherePosition($value)
 * @method static Builder|Menu whereSiteId($value)
 * @method static Builder|Menu whereTitle($value)
 * @method static Builder|Menu whereUpdatedAt($value)
 * @method static Builder|Menu whereUrl($value)
 * @mixin Eloquent
 * @method static Builder|Menu newModelQuery()
 * @method static Builder|Menu newQuery()
 * @method static Builder|Menu query()
 * @property int $sort_order
 * @property int|null $parent_id
 * @property int|null $lft
 * @property int|null $rgt
 * @property int|null $depth
 * @property int $disabled
 * @property int $is_visible
 * @property-read \Baum\Extensions\Eloquent\Collection|Menu[] $children
 * @property-read int|null $children_count
 * @property-read Menu|null $parent
 * @method static \Baum\Extensions\Eloquent\Collection|static[] all($columns = ['*'])
 * @method static Builder|Menu disabled()
 * @method static Builder|Menu enabled()
 * @method static \Baum\Extensions\Eloquent\Collection|static[] get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Node limitDepth($limit)
 * @method static Builder|Menu visible($flag)
 * @method static Builder|Menu whereDepth($value)
 * @method static Builder|Menu whereDisabled($value)
 * @method static Builder|Menu whereIsVisible($value)
 * @method static Builder|Menu whereLft($value)
 * @method static Builder|Menu whereParentId($value)
 * @method static Builder|Menu whereRgt($value)
 * @method static Builder|Menu whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Node withoutNode($node)
 * @method static \Illuminate\Database\Eloquent\Builder|Node withoutRoot()
 * @method static \Illuminate\Database\Eloquent\Builder|Node withoutSelf()
 * @property-read mixed $image_url
 * @property mixed $images
 * @property-read mixed $thumbs
 */
class Menu extends Node
{
    use Media;

    protected static string $sortableGroupField = 'site_id';

    protected $table = 'menu';

    protected $fillable = ['site_id', 'title', 'url', 'as_tree', 'image', 'sort_order',
        'parent_id', 'disabled', 'is_visible'];

    protected $parentColumn = 'parent_id';
    protected $leftColumn = 'lft';
    protected $rightColumn = 'rgt';
    protected $depthColumn = 'depth';
    protected $orderColumn = 'sort_order';

    protected $guarded = ['id', 'parent_id', 'lft', 'rgt', 'depth'];

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function scopeBySite($query, $site_id)
    {
        return $query->where('site_id', $site_id);
    }

    public function scopeEnabled($query)
    {
        return $query->whereDisabled(0);
    }

    public function scopeDisabled($query)
    {
        return $query->whereEnabled(0);
    }

    public function scopeVisible($query, $flag)
    {
        return $query->whereIsVisible((int)$flag);
    }
}
