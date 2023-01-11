<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\ObjectField
 *
 * @property int $id
 * @property string $name
 * @property string $field_type
 * @property string|null $placeholder
 * @property string $alias
 * @property int $required
 * @property int $object_field_group_id
 * @property int $use_in_filter
 * @property int $use_in_catalog_list
 * @property-read Collection|ObjectFieldValue[] $fieldValues
 * @property-read mixed $api
 * @property-read mixed $data
 * @property-read ObjectFieldGroup $objectFieldGroup
 * @method static Builder|ObjectField newModelQuery()
 * @method static Builder|ObjectField newQuery()
 * @method static Builder|ObjectField query()
 * @method static Builder|ObjectField whereAlias($value)
 * @method static Builder|ObjectField whereDefaultValue($value)
 * @method static Builder|ObjectField whereFieldType($value)
 * @method static Builder|ObjectField whereId($value)
 * @method static Builder|ObjectField whereName($value)
 * @method static Builder|ObjectField whereObjectFieldGroupId($value)
 * @method static Builder|ObjectField whereRequired($value)
 * @method static Builder|ObjectField whereUseInCatalogList($value)
 * @method static Builder|ObjectField whereUseInFilter($value)
 * @mixin Eloquent
 * @property string|null $default_value
 * @property-read int|null $field_values_count
 */
class ObjectField extends Model
{
    const FIELD_TYPE_INPUT = 0;
    const FIELD_TYPE_CHECKBOX = 1;
    const FIELD_TYPE_SELECT = 2;
    const FIELD_TYPE_TOWN = 3;
    const FIELD_TYPE_COUNTRY = 4;
    const FIELD_TYPE_FILE = 5;
    const FIELD_TYPE_RANGE = 6;
    const FIELD_TYPE_TEXTAREA = 7;
    const FIELD_TYPE_RADIO = 8;
    const FIELD_TYPE_DATE = 9;
    const FIELD_TYPE_MULTISELECT = 10;
    const FIELD_TYPE_IMAGE = 12;

    static $fieldTypes = [
        self::FIELD_TYPE_INPUT => [
            'name' => 'Строка',
            'type' => 'text',
            'id' => self::FIELD_TYPE_INPUT
        ],
        self::FIELD_TYPE_CHECKBOX => [
            'name' => 'Чекбокс',
            'type' => 'checkbox',
            'id' => self::FIELD_TYPE_CHECKBOX
        ],
        self::FIELD_TYPE_SELECT => [
            'name' => 'Селект',
            'type' => 'select',
            'id' => self::FIELD_TYPE_SELECT
        ],
        self::FIELD_TYPE_TOWN => [
            'name' => 'Выбор города',
            'type' => 'text',
            'id' => self::FIELD_TYPE_TOWN
        ],
        self::FIELD_TYPE_COUNTRY => [
            'name' => 'Выбор страны',
            'type' => 'text',
            'id' => self::FIELD_TYPE_COUNTRY
        ],
        self::FIELD_TYPE_FILE => [
            'name' => 'Загрузка файла',
            'type' => 'file',
            'id' => self::FIELD_TYPE_FILE
        ],
        self::FIELD_TYPE_IMAGE => [
            'name' => 'Загрузка фото',
            'type' => 'image',
            'id' => self::FIELD_TYPE_IMAGE
        ],
        self::FIELD_TYPE_RANGE => [
            'name' => 'Промежуток выбора (числовой)',
            'type' => 'range',
            'id' => self::FIELD_TYPE_RANGE
        ],
        self::FIELD_TYPE_TEXTAREA => [
            'name' => 'Описание',
            'type' => 'textarea',
            'id' => self::FIELD_TYPE_TEXTAREA
        ],
        self::FIELD_TYPE_RADIO => [
            'name' => 'Список (radio)',
            'type' => 'radio',
            'id' => self::FIELD_TYPE_RADIO
        ],
        self::FIELD_TYPE_DATE => [
            'name' => 'Дата',
            'type' => 'date',
            'id' => self::FIELD_TYPE_DATE
        ],
        self::FIELD_TYPE_MULTISELECT => [
            'name' => 'Мультивыбор',
            'type' => 'select',
            'id' => self::FIELD_TYPE_MULTISELECT
        ]
    ];

    static array $notRequired = [self::FIELD_TYPE_CHECKBOX];
    public static bool $md5Alias = true;
    public $timestamps = false;
    protected $table = 'object_field';
    protected $fillable = ['name', 'placeholder', 'alias', 'field_type', 'required',
        'object_field_group_id', 'use_in_filter', 'use_in_catalog_list'];

    protected $appends = ['field_type', 'data', 'api'];

    public static function getObjectValue($id, $userData)
    {
        if (count($userData) > 0) {
            foreach ($userData as $value) {
                if ($id == $value->field_id) {
                    return $value->value;
                }
            }
        }

        return null;
    }

    public function fieldValues(): HasMany
    {
        return $this->hasMany(ObjectFieldValue::class);
    }

    public function save(array $options = []): bool
    {
        $this->alias = $this->alias();
        return parent::save($options);
    }

    private function alias(): string
    {
        if (static::$md5Alias == true) {
            return md5($this->name . microtime(true));
        } else {
            return $this->alias;
        }
    }

    public function objectFieldGroup(): BelongsTo
    {
        return $this->belongsTo(ObjectFieldGroup::class);
    }

    public function getFieldTypeAttribute(): array
    {
        $fieldType = null;

        if (isset($this->attributes['field_type'])) {
            $fieldType = self::$fieldTypes[$this->attributes['field_type']];
        }

        return $fieldType;
    }

    public function getApiAttribute()
    {
        $defaultApiArray = [
            'api_link' => route('search.city'),
            'api_params' => 'term',
            'api_return_value' => 'title_ru'
        ];

        switch ($this->field_type['id']) {
            case self::FIELD_TYPE_TOWN:
                return $defaultApiArray;
                break;
            case self::FIELD_TYPE_COUNTRY:
                $defaultApiArray['api_link'] = route('search.country');
                return $defaultApiArray;
                break;
            default:
                return null;
                break;
        }
    }

    public function getDataAttribute()
    {
        $data = null;

        $data = $this->{'getValue' . $this->field_type['id']}($this);

        return [
            'value' => $data['value'],
            'select_fields' => $data['select_fields']
        ];
    }

    public function getValue0($value)
    {
        return [
            'value' => null,
            'select_fields' => null
        ];
    }

    public function getValue1($value)
    {
        return [
            'value' => null,
            'select_fields' => null
        ];
    }

    public function getValue2($thisValue)
    {

        $thisValue = $this->getSelectValue($thisValue);

        return [
            'value' => null,
            'select_fields' => $thisValue
        ];
    }

    private function getSelectValue($thisValue)
    {

        if ($thisValue->fieldValues->count() > 0) {

            $thisValue = $thisValue->fieldValues->map(function ($data) {
                $dataFields = [];
                if (!empty($data->data_node_id)) {
                    $records = Neo4j::client()->run("MATCH (n:Object)-[:HAS]-(m:Object) WHERE ID(n)=" .
                        (int)$data->data_node_id . " RETURN m");
                    foreach ($records->getRecords() as $record) {

                        if ($record->hasValues()) {

                            foreach ($record->values() as $dataValue) {
                                $dataFields[] = $dataValue->values()['name'];
                            }
                        }
                    }
                }
                return $dataFields;
            })->toArray();

        } else {
            $thisValue = null;
        }
        return $thisValue;
    }

    public function getValue3($value)
    {
        return [
            'value' => null,
            'select_fields' => null
        ];
    }

    public function getValue4($value)
    {
        return [
            'value' => null,
            'select_fields' => null
        ];
    }

    public function getValue5($value)
    {
        return [
            'value' => null,
            'select_fields' => null
        ];
    }

    /**
     * @param $value
     * @return array
     */
    public function getValue6($value)
    {
        $selectFields = null;

        if ($value->fieldValues) {
            $selectFields = $value->fieldValues->map(function ($fieldValue) {
                return $fieldValue->value;
            })->toArray();
        }

        return [
            'value' => null,
            'select_fields' => $selectFields
        ];
    }

    public function getValue7($value)
    {
        return [
            'value' => null,
            'select_fields' => null
        ];
    }

    public function getValue8($value)
    {
        $value = $this->getSelectValue($value);
        return [
            'value' => null,
            'select_fields' => $value
        ];
    }

    public function getValue9($value)
    {
        return [
            'value' => null,
            'select_fields' => null
        ];
    }

    public function getValue10($thisValue)
    {

        $thisValue = $this->getSelectValue($thisValue);

        return [
            'value' => null,
            'select_fields' => $thisValue
        ];
    }

    public function getValue11($value)
    {
        return [
            'value' => null,
            'select_fields' => null
        ];
    }

    public function getValue12($value)
    {
        return [
            'value' => null,
            'select_fields' => null
        ];
    }
}