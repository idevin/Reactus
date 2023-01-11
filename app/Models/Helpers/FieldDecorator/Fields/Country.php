<?php


namespace App\Models\Helpers\FieldDecorator\Fields;


use App\Models\Helpers\FieldDecorator\FieldInterface;

class Country implements FieldInterface
{
    public function decorate(mixed $value, mixed $field): string
    {
        return ucfirst($value);
    }

    public function save(mixed $value, mixed $field): string
    {
        return ucfirst($value);
    }

    public function validate(mixed $value, mixed $field): mixed
    {
        return true;
    }
}