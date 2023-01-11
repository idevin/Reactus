<?php

namespace App\Models\Helpers\FieldDecorator;

class NeoData implements FieldInterface
{
    public function decorate(mixed $value, mixed $field): string
    {
        return readNeoDataFile($field->id);
    }

    public function save(mixed $value, mixed $field): mixed
    {
        return saveNeoDataFile($value, $field->id);
    }

    public function validate(mixed $value, mixed $field): bool
    {
        return true;
    }
}