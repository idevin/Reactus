<?php


namespace App\Models\Helpers\FieldDecorator;


use App\Models\Field;

interface FieldInterface
{
    public function decorate(mixed $value, mixed $field): mixed;

    public function save(mixed $value, mixed $field): mixed;

    public function validate(mixed $value, mixed $field):mixed;
}