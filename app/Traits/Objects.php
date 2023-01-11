<?php

namespace App\Traits;

use App\Models\NeoCard;
use Illuminate\Http\JsonResponse;

trait Objects
{
    public static function validateObject($fromId, $toId, $relation): array|JsonResponse
    {
        if (!$fromId || !$toId) {
            return Response::response()->error('Не заданы все параметры');
        }

        if (!in_array($relation, array_keys(NeoCard::$treeRelations))) {
            return Response::response()->error('Неверное соотношение');
        }

        $fromCard = NeoCard::query()->find($fromId);

        if (!$fromCard) {
            return Response::response()->error('Карточка не найдена (от)');
        }

        $toCard = NeoCard::query()->find($toId);

        if (!$toCard) {
            return Response::response()->error('Карточка не найдена (до)');
        }

        return compact('fromCard', 'toCard');
    }
}