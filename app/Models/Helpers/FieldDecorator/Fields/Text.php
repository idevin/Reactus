<?php


namespace App\Models\Helpers\FieldDecorator\Fields;


use App\Models\Helpers\FieldDecorator\FieldInterface;

class Text implements FieldInterface
{
    public function decorate(mixed $value, mixed $field): string
    {
        return self::getValue($value);
    }

    public static function getValue($value): string
    {
        $value = strip_tags(trim($value));
        $value = preg_replace('#\s+#', " ", $value);
        return preg_replace('#[\n\r]+#', '', $value);
    }

    public function save(mixed $value, mixed $field): mixed
    {
       return self::getValue($value);
    }

    public function validate(mixed $value, mixed $field): bool
    {
        return mb_strlen($value) <= 254;
    }
}