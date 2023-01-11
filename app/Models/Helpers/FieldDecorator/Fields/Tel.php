<?php


namespace App\Models\Helpers\FieldDecorator\Fields;


use App\Models\Helpers\FieldDecorator\FieldInterface;
use Propaganistas\LaravelPhone\PhoneNumber;

class Tel implements FieldInterface
{

    public function decorate(mixed $value, mixed $field): ?string
    {
        return $this->validatePhone($value);
    }

    public function validatePhone($value): string
    {
        try {
            $value = PhoneNumber::make($value)->formatRFC3966();
        } catch (\Exception $e) {
            if (env('APP_DEBUG_VARS') === true) {
                debugvars($e->getTraceAsString());
            }
            $value = '';
        }

        return $value;
    }

    public function save(mixed $value, mixed $field): mixed
    {
        return PhoneNumber::make($value)->formatRFC3966();
    }

    public function validate(mixed $value, mixed $field): mixed
    {
        $value = $this->validatePhone($value);
        return (bool)$value;
    }
}