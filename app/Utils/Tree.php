<?php

namespace App\Utils;

use Illuminate\Support\Collection;

class Tree
{

    public function __construct(
        public string $modelClass,
        public string $json
    )
    {
    }

    public function update()
    {
        $root = $this->modelClass::root();

        $movements = [];
        $subtreeId = $root->id;

        $this->sortMovementsByDepth($this->json, $movements, $subtreeId);
        ksort($movements);

        $movements = call_user_func_array('array_merge', $movements);
        $movements = Collection::make($movements)->keyBy('id');
        $rootDepth = $root->depth;
        $rootLeft = $root->lft;

        $nodes = $root->getDescendants(['id', 'lft', 'rgt', 'depth', 'parent_id']);

        $movedIds = $movements->keys()->toArray();

        $dictionary = $nodes->getDictionary();

        $unmoved = new \Baum\Extensions\Eloquent\Collection();

        foreach ($dictionary as $n) {
            if (!in_array($n->getKey(), $movedIds)) {
                $unmoved[] = $n;
            }
        }

        $moved = new \Baum\Extensions\Eloquent\Collection();

        foreach ($movedIds as $i) {
            if (isset($dictionary[$i])) {
                $moved[] = $dictionary[$i];
            }
        }

        $orderColumn = $root->getOrderColumnName();

        foreach ($dictionary as $n) {
            $n->__order = $n->$orderColumn;
        }

        $orderedNodes = $moved->merge($unmoved);

        $order = 1;
        foreach ($orderedNodes as $n) {
            $n->$orderColumn = $order++;
            if (isset($movements[$n->getKey()])) {
                $n->parent_id = $movements[$n->getKey()]['parent_id'];
            }
        }

        $newTree = $orderedNodes->first();

        foreach ($dictionary as $n) {
            $n->$orderColumn = $n->__order;
            unset($n->__order);
        }

        $newRoot = $newTree->first();

        if ($newRoot->getKey() != $root->getKey() || empty($newTree)) {
            throw new LogicException("Invalid tree");
        }


        $left = $rootLeft - 1;
        $depth = $rootDepth;
        $reindex = function ($tree, $reindex, $depth) use (&$left) {
            foreach ($tree as $node) {
                $left++;
                $node->lft = $left;
                $node->depth = $depth;
                $reindex($node->children, $reindex, $depth + 1);
                $left++;
                $node->rgt = $left;
            }
        };

        $reindex($newTree->get(), $reindex, $depth);

        $bulk = [];
        foreach ($dictionary as $n) {

            if ($n->isDirty()) {
                $bulk[$n->getKey()] = [
                    'lft' => $n->lft,
                    'rgt' => $n->rgt,
                    'depth' => $n->depth,
                    'parent_id' => $n->parent_id
                ];
            }
        }

        foreach ($bulk as $id => $fields) {
            DB::table($root->getTable())
                ->where($root->getKeyName(), $id)
                ->update($fields);
        }
    }

    protected function sortMovementsByDepth($tree, &$children, $id, $depth = 1)
    {
        foreach ($tree as $node) {
            if (!empty($node['children'])) {
                $this->sortMovementsByDepth($node['children'], $children, $node['id'], $depth + 1);
            }
            $new = $node;
            $new['parent_id'] = $id;
            unset($new['children']);

            $children[$depth][] = $new;
        }
    }

}