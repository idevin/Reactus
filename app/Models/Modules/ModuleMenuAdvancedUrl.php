<?php

namespace App\Models\Modules;

use App\Contracts\Module as ModuleInterface;
use Baum\Node as BaumNode;


/**
 * @method static create(mixed $item)
 */
class ModuleMenuAdvancedUrl extends BaumNode implements ModuleInterface
{
    public $timestamps = false;
    protected $table = 'module_menu_advanced_urls';

    protected $parentColumn = 'parent_id';
    protected $leftColumn = 'lft';
    protected $rightColumn = 'rgt';
    protected $depthColumn = 'depth';
    protected $orderColumn = 'sort_order';

    protected $guarded = ['id', 'parent_id', 'lft', 'rgt', 'depth'];

    protected $fillable = [
        'name', 'url', 'sort_order', 'module_menu_advanced_id', 'parent_id', 'image', 'disabled'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function menu()
    {
        return $this->belongsTo(ModuleMenuAdvanced::class);
    }

    static function options(...$args)
    {
        // TODO: Implement options() method.
    }

    public static function getBlock(...$args)
    {
        // TODO: Implement getBlock() method.
    }

    static function id(...$args)
    {
        // TODO: Implement id() method.
    }

    public function scopeBySite($query, $siteId)
    {
        return $query->where('site_id', $siteId);
    }

    private static function getNodes($site, $withRoot)
    {
        $menuRoots = ModuleMenuAdvancedUrl::roots();
        $nodes = [];

        if ($menuRoots) {
            $node = $menuRoots->bySite($site->id)->get()->first();
            $nodes = null;

            $nodes = function ($node, $withRoot) {
                return $withRoot ? $node->getDescendantsAndSelf() : $node->getDescendants();
            };

            if ($node) {
                $nodes = $nodes($node, $withRoot);
            }
        }

        return $nodes;
    }
}