<?php


namespace App\Models\Helpers\FieldDecorator\Fields;


use App\Models\City as CityModel;
use App\Models\Helpers\FieldDecorator\FieldInterface;

class City implements FieldInterface
{
    public function decorate(mixed $value, mixed $field): string
    {
        return ucfirst($value);
    }

    public function save(mixed $value, mixed $field): string
    {
        return ucfirst($value);
    }

    public function validate(mixed $value, mixed $field): bool
    {
        $result = CityModel::search($value, \Auth::user());

        return count($result) > 0;
    }
}