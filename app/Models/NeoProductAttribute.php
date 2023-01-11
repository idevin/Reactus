<?php

namespace App\Models;

class NeoProductAttribute extends Neo4j
{
    const TYPE_IMAGE = 1;
    const TYPE_SELECT = 2;
    const TYPE_DESCRIPTION = 3;
    const TYPE_COLOR = 4;
    const TYPE_STROKE = 5;
    const TYPE_PRICE = 6;
    const TYPE_CURRENCY = 7;
    const TYPE_CHECKBOX = 8;
    const ATTRIBUTE_TYPES = [
        [
            "id" => self::TYPE_IMAGE,
            "name" => "Галлерея"
        ],
        [
            "id" => self::TYPE_SELECT,
            "name" => "Список"
        ],
        [
            "id" => self::TYPE_DESCRIPTION,
            "name" => "Описание"
        ],
        [
            "id" => self::TYPE_COLOR,
            "name" => "Цвет"
        ],
        [
            "id" => self::TYPE_STROKE,
            "name" => "Строка"
        ]
        , [
            "id" => self::TYPE_PRICE,
            "name" => "Цена"
        ],
        [
            "id" => self::TYPE_CURRENCY,
            "name" => "Валюта"
        ],
        [
            "id" => self::TYPE_CHECKBOX,
            "name" => "Чекбокс"
        ],
    ];
    public $timestamps = false;
    protected $label = 'ProductAttribute';
    protected $fillable = ['name', 'values', 'type', 'sort_order', 'use_in_filter'];
    protected $connection = 'neo4j';

    public function catalog()
    {
        return $this->belongsTo(NeoCatalog::class, 'ATTRIBUTE');
    }

    public function productValues()
    {
        return $this->hasMany(NeoProductValue::class, 'VALUE_ATTRIBUTE');
    }

    public function setValuesAttribute($values)
    {
        $this->attributes['values'] = serialize($values);
    }

    public function getValuesAttribute($values)
    {
        $unserializedValue = unserialize($values);
        $encoded = json_decode($unserializedValue);

        if (!$encoded) {
            return $unserializedValue;
        }

        return $encoded;
    }

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = strip_tags(trim($name));
    }
}