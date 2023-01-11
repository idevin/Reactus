<?php


namespace App\Models\Helpers\FieldDecorator\Fields;


use App\Models\Helpers\FieldDecorator\FieldInterface;

class Range implements FieldInterface
{
    public function decorate(mixed $value, mixed $field): string
    {
        return (int)$value;
    }

    public function save(mixed $value, mixed $field): mixed
    {
        return (int)$value;
    }

    public function validate(mixed $value, mixed $field): mixed
    {
        $values = $field->values->sortBy('id')->pluck('value')->toArray();

        $from = (int)$values[0];
        $to = (int)$values[1];
        $value = (int)$value;

        return $value >= $from && $value <= $to;
    }
}