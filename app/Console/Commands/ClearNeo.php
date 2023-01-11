<?php

namespace App\Console\Commands;

use App\Models\Neo4j;
use App\Models\NeoCard;
use App\Models\NeoCatalog;
use App\Models\NeoCategory;
use App\Models\NeoField;
use App\Models\NeoFieldGroup;
use App\Models\NeoUserFieldGroup;
use App\Models\NeoCatalogFieldGroup;
use App\Models\NeoUserCard;
use Exception;
use GraphAware\Neo4j\Client\Exception\Neo4jExceptionInterface;
use Illuminate\Console\Command;

class ClearNeo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'neo4j:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear User data';

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws Exception
     * @throws Neo4jExceptionInterface
     */
    public function handle()
    {
        $neoObjects = NeoCatalog::all();
        foreach ($neoObjects as $neoObject) {
            $cards = $neoObject->cards;
            if (count($cards) > 0) {
                foreach ($cards as $card) {
                    $card->delete();
                }
            }
            $userDatas = $neoObject->userDatas;
            foreach ($userDatas as $userData) {
                $userData->delete();
            }
        }

        NeoUserFieldGroup::with(['fields'])->delete();
        NeoField::query()->delete();

        $catalogs = NeoCatalog::all();
        foreach ($catalogs as $catalog) {
            if (count($catalog->productAttributes) > 0) {
                $catalog->productAttributes->map(function ($attribute) {
                    $attribute->delete();
                });
            }
            if (!empty($catalog->categories)) {
                foreach ($catalog->categories as $category) {
                    $category->delete();
                }
            }

            $catalog->delete();
        }

        $userDatas = NeoUserCard::all();

        if (count($userDatas) > 0) {
            $userDatas->map(function ($user) {
                $user->delete();
            });
        }

        $categories = NeoCategory::all();
        if (!empty($categories)) {
            $categories->map(function ($category) {
                $category->delete();
            });
        }

        $cards = NeoCard::all();
        if (!empty($cards)) {
            $cards->map(function ($card) {
                $card->delete();
            });
        }

        $fieldGroups = NeoFieldGroup::all();
        if (!empty($fieldGroups)) {
            $fieldGroups->map(function ($fieldGroup) {
                $fieldGroup->delete();
            });
        }

        $fieldGroups = NeoCatalogFieldGroup::all();
        if (!empty($fieldGroups)) {
            $fieldGroups->map(function ($fieldGroup) {
                $fieldGroup->delete();
            });
        }

        Neo4j::client()->run('MATCH (o:Object) DETACH DELETE o;');

        return true;
    }
}