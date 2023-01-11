<?php


namespace App\Models\Helpers\FieldDecorator\Fields;


use App\Models\Helpers\FieldDecorator\FieldInterface;

class Checkbox implements FieldInterface
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
        return (int)$value >= 0;
    }
}