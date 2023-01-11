<?php


namespace App\Models\Helpers\FieldDecorator\Fields;


use App\Models\Helpers\FieldDecorator\FieldInterface;
use App\Models\Neo4j;

class CardSelect implements FieldInterface
{
    public function decorate(mixed $value, mixed $field): int
    {
        return (int)$value;
    }

    public function save(mixed $value, mixed $field): int
    {
        return (int)$value;
    }

    public function validate(mixed $value, mixed $field): bool
    {
        $userId = \Auth::user()->id;
        $value = (int)$value;

        $found = Neo4j::client()->run("MATCH (c:Catalog)-[ca:CARD]->(car:Card) 
        WHERE c.user_id={$userId} AND ID(car)={$value} RETURN car LIMIT 1");

        return count($found) === 1;
    }
}