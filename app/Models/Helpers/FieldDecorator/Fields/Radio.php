<?php


namespace App\Models\Helpers\FieldDecorator\Fields;


use App\Models\Helpers\FieldDecorator\FieldInterface;

class Radio implements FieldInterface
{
    public function decorate(mixed $value, mixed $field): mixed
    {
        return $value;
    }

    public function save(mixed $value, mixed $field): mixed
    {
       return $value;
    }

    public function validate(mixed $value, mixed $field): bool
    {
        $values = $field->values->pluck('value')->toArray();

        return in_array($value, $values);
    }
}