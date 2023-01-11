<?php


namespace App\Models\Helpers\FieldDecorator\Fields;


use App\Models\Helpers\FieldDecorator\FieldInterface;
use Carbon\Carbon;

class Date implements FieldInterface
{
    public function decorate(mixed $value, mixed $field): ?string
    {
        return datetime_format($value, true);
    }

    public function save(mixed $value, mixed $field): mixed
    {
        try {
            return Carbon::parse($value);
        } catch (\Exception $e) {
            if (env('APP_DEBUG_VARS') == true) {
                debugvars($e->getTraceAsString());
            }
            return null;
        }
    }

    public function validate(mixed $value, mixed $field): mixed
    {
        $result = true;

        try {
            Carbon::parse($value);
        } catch (\Exception $e) {
            if (env('APP_DEBUG_VARS') == true) {
                debugvars($e->getTraceAsString());
            }
            $result = false;
        }

        return $result;
    }
}