<?php


namespace App\Models\Helpers\FieldDecorator\Fields;


use App\Models\Helpers\FieldDecorator\FieldInterface;

class Feedback implements FieldInterface
{
    public function decorate(mixed $value, mixed $field): string
    {
        return $value;
    }

    public function save(mixed $value, mixed $field): mixed
    {
        // TODO: Implement save() method.
    }

    public function validate(mixed $value, mixed $field): mixed
    {
        // TODO: Implement validate() method.
    }
}