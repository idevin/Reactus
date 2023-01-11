<?php

namespace App\Models;

use App\Models\Helpers\FieldDecorator\Fields\CardSelect;
use App\Models\Helpers\FieldDecorator\Fields\Checkbox;
use App\Models\Helpers\FieldDecorator\Fields\Country as CountryDecorator;
use App\Models\Helpers\FieldDecorator\Fields\Date;
use App\Models\Helpers\FieldDecorator\Fields\DatePeriod;
use App\Models\Helpers\FieldDecorator\Fields\Editor;
use App\Models\Helpers\FieldDecorator\Fields\File;
use App\Models\Helpers\FieldDecorator\Fields\Image;
use App\Models\Helpers\FieldDecorator\Fields\MultiSelect;
use App\Models\Helpers\FieldDecorator\Fields\Number;
use App\Models\Helpers\FieldDecorator\Fields\Price;
use App\Models\Helpers\FieldDecorator\Fields\Radio;
use App\Models\Helpers\FieldDecorator\Fields\Range;
use App\Models\Helpers\FieldDecorator\Fields\Rates;
use App\Models\Helpers\FieldDecorator\Fields\Select;
use App\Models\Helpers\FieldDecorator\Fields\Tariff;
use App\Models\Helpers\FieldDecorator\Fields\TariffPrice;
use App\Models\Helpers\FieldDecorator\Fields\Text;
use App\Models\Helpers\FieldDecorator\Fields\Textarea;
use App\Models\Helpers\FieldDecorator\Fields\City;
use Vinelab\NeoEloquent\Eloquent\Relations\BelongsTo;
use Vinelab\NeoEloquent\Eloquent\Relations\HasMany;

/**
 * @property mixed object
 * @property mixed field_type
 * @method static whereUseInCatalogList(int $int)
 */
class NeoCatalogField extends Neo4j
{
    const FIELD_TYPE_INPUT = 0;
    const FIELD_TYPE_CHECKBOX = 1;
    const FIELD_TYPE_SELECT = 2;
    const FIELD_TYPE_CITY = 3;
    const FIELD_TYPE_COUNTRY = 4;
    const FIELD_TYPE_FILE = 5;
    const FIELD_TYPE_RANGE = 6;
    const FIELD_TYPE_TEXTAREA = 7;
    const FIELD_TYPE_RADIO = 8;
    const FIELD_TYPE_DATE = 9;
    const FIELD_TYPE_MULTISELECT = 10;
    const FIELD_TYPE_NUMBER = 11;
    const FIELD_TYPE_IMAGE = 12;
    const FIELD_TYPE_FEEDBACK = 13;
    const FIELD_TYPE_EDITOR = 14;
    const FIELD_TYPE_TARIFF = 15;
    const FIELD_TYPE_CARD_SELECT = 16;
    const FIELD_TYPE_DATE_PERIOD = 17;
    const FIELD_TYPE_TARIFF_PRICE = 18;
    const FIELD_TYPE_RATES_TABLE = 19;
    const FIELD_TYPE_PRICE = 20;

    static array $fieldTypes = [
        self::FIELD_TYPE_INPUT => [
            'name' => 'Строка',
            'type' => 'text',
            'id' => self::FIELD_TYPE_INPUT,
            'class' => Text::class
        ],
        self::FIELD_TYPE_CHECKBOX => [
            'name' => 'Чекбокс',
            'type' => 'checkbox',
            'id' => self::FIELD_TYPE_CHECKBOX,
            'class' => Checkbox::class
        ],
        self::FIELD_TYPE_SELECT => [
            'name' => 'Селект',
            'type' => 'select',
            'id' => self::FIELD_TYPE_SELECT,
            'class' => Select::class
        ],
        self::FIELD_TYPE_CITY => [
            'name' => 'Выбор города',
            'type' => 'text',
            'id' => self::FIELD_TYPE_CITY,
            'class' => City::class
        ],
        self::FIELD_TYPE_COUNTRY => [
            'name' => 'Выбор страны',
            'type' => 'text',
            'id' => self::FIELD_TYPE_COUNTRY,
            'class' => CountryDecorator::class
        ],
        self::FIELD_TYPE_FILE => [
            'name' => 'Загрузка файла',
            'type' => 'file',
            'id' => self::FIELD_TYPE_FILE,
            'class' => File::class
        ],
        self::FIELD_TYPE_IMAGE => [
            'name' => 'Загрузка фото',
            'type' => 'image',
            'id' => self::FIELD_TYPE_IMAGE,
            'class' => Image::class
        ],
        self::FIELD_TYPE_RANGE => [
            'name' => 'Промежуток выбора (числовой)',
            'type' => 'range',
            'id' => self::FIELD_TYPE_RANGE,
            'class' => Range::class
        ],
        self::FIELD_TYPE_TEXTAREA => [
            'name' => 'Описание',
            'type' => 'textarea',
            'id' => self::FIELD_TYPE_TEXTAREA,
            'class' => Textarea::class
        ],
        self::FIELD_TYPE_RADIO => [
            'name' => 'Список (radio)',
            'type' => 'radio',
            'id' => self::FIELD_TYPE_RADIO,
            'class' => Radio::class
        ],
        self::FIELD_TYPE_DATE => [
            'name' => 'Дата',
            'type' => 'date',
            'id' => self::FIELD_TYPE_DATE,
            'class' => Date::class
        ],
        self::FIELD_TYPE_MULTISELECT => [
            'name' => 'Мультивыбор',
            'type' => 'multiselect',
            'id' => self::FIELD_TYPE_MULTISELECT,
            'class' => MultiSelect::class
        ],
        self::FIELD_TYPE_NUMBER => [
            'name' => 'Число',
            'type' => 'number',
            'id' => self::FIELD_TYPE_NUMBER,
            'class' => Number::class
        ],
        self::FIELD_TYPE_FEEDBACK => [
            'name' => 'Обратная связь',
            'type' => 'feedback',
            'id' => self::FIELD_TYPE_FEEDBACK,
            'class' => Feedback::class
        ],
        self::FIELD_TYPE_EDITOR => [
            'name' => 'Редактор',
            'type' => 'editor',
            'id' => self::FIELD_TYPE_EDITOR,
            'class' => Editor::class
        ],
        self::FIELD_TYPE_TARIFF => [
            'name' => 'Тарифная сетка (дата)',
            'type' => 'tariff',
            'id' => self::FIELD_TYPE_TARIFF,
            'class' => Tariff::class
        ],
        self::FIELD_TYPE_TARIFF_PRICE => [
            'name' => 'Тарифная сетка (цена)',
            'type' => 'tariff',
            'id' => self::FIELD_TYPE_TARIFF_PRICE,
            'class' => TariffPrice::class
        ],
        self::FIELD_TYPE_RATES_TABLE => [
            'name' => 'Расценки',
            'type' => 'rates_table',
            'id' => self::FIELD_TYPE_RATES_TABLE,
            'class' => Rates::class
        ],
        self::FIELD_TYPE_CARD_SELECT => [
            'name' => 'Список карточек',
            'type' => 'card_select',
            'id' => self::FIELD_TYPE_CARD_SELECT,
            'class' => CardSelect::class
        ],
        self::FIELD_TYPE_DATE_PERIOD => [
            'name' => 'Промежуток дат',
            'type' => 'date_period',
            'id' => self::FIELD_TYPE_DATE_PERIOD,
            'class' => DatePeriod::class
        ],
        self::FIELD_TYPE_PRICE => [
            'name' => 'Цена',
            'type' => 'price',
            'id' => self::FIELD_TYPE_PRICE,
            'class' => Price::class
        ]
    ];

    static array $notRequired = [self::FIELD_TYPE_CHECKBOX];

    public $timestamps = false;
    protected $label = 'Field';
    protected $connection = 'neo4j';
    protected $appends = ['api'];

    protected $casts = ['field_type' => 'integer'];

    protected $fillable = ['name', 'placeholder', 'alias', 'field_type',
        'required', 'use_in_filter', 'use_in_catalog_list', 'sort_order'];

    public function fieldGroup(): BelongsTo
    {
        return $this->belongsTo(NeoCatalogFieldGroup::class, 'FIELD');
    }

    public function userFields(): HasMany
    {
        return $this->hasMany(NeoUserField::class, 'RELATED_FIELD');
    }

    public function userField(): BelongsTo
    {
        return $this->belongsTo(NeoUserField::class, 'RELATED_FIELD');
    }

    public function values(): HasMany
    {
        return $this->hasMany(NeoCatalogFieldValue::class, 'RELATED')->orderBy('sort_order');
    }

    public function getApiAttribute(): ?array
    {
        $defaultApiArray = [
            'api_link' => route('search.city'),
            'api_params' => 'term',
            'api_return_value' => 'title_ru'
        ];

        switch ($this->field_type) {
            case self::FIELD_TYPE_CITY:
                return $defaultApiArray;
            case self::FIELD_TYPE_COUNTRY:
                $defaultApiArray['api_link'] = route('search.country');
                return $defaultApiArray;
            case self::FIELD_TYPE_CARD_SELECT:
                $defaultApiArray['api_link'] = route('search.card');
                $defaultApiArray['api_return_value'] = 'name';
                return $defaultApiArray;
            default:
                return null;
        }
    }
}

