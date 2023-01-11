<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;

/**
 * Class Field
 *
 * @package App\Models
 * @property int $id
 * @property int $sort_order
 * @property int $field_type
 * @property string|null $default_value
 * @property string $alias
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $site_id
 * @property string|null $name
 * @property int $field_group_id
 * @property int $required
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Feedback[] $feedback
 * @property-read \App\Models\FieldGroup $field_group
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FieldValue[] $field_values
 * @property-read mixed $data
 * @property-read mixed $select_values
 * @property-read \App\Models\Site|null $site
 * @method static Builder|\App\Models\Field newModelQuery()
 * @method static Builder|\App\Models\Field newQuery()
 * @method static Builder|\App\Models\Field query()
 * @method static Builder|\App\Models\Field whereAlias($value)
 * @method static Builder|\App\Models\Field whereCreatedAt($value)
 * @method static Builder|\App\Models\Field whereDefaultValue($value)
 * @method static Builder|\App\Models\Field whereDeletedAt($value)
 * @method static Builder|\App\Models\Field whereFieldGroupId($value)
 * @method static Builder|\App\Models\Field whereFieldType($value)
 * @method static Builder|\App\Models\Field whereId($value)
 * @method static Builder|\App\Models\Field whereName($value)
 * @method static Builder|\App\Models\Field whereRequired($value)
 * @method static Builder|\App\Models\Field whereSiteId($value)
 * @method static Builder|\App\Models\Field whereSortOrder($value)
 * @method static Builder|\App\Models\Field whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read int|null $feedback_count
 * @property-read int|null $field_values_count
 * @property string|null $placeholder
 * @method static Builder|\App\Models\Field wherePlaceholder($value)
 */
class Field extends Model
{
    const FIELD_TYPE_INPUT = 0;
    const FIELD_TEXTAREA = 1;
    const FIELD_TYPE_CHECKBOX = 3;
    const FIELD_TYPE_SELECT = 4;
    const FIELD_TYPE_TOWN = 5;
    const FIELD_TYPE_FILE = 6;
    const FIELD_TYPE_DATE = 7;
    const FIELD_TYPE_TEL = 8;
    const FIELD_TYPE_IMAGE = 9;


    static array $fieldTypes = [

        self::FIELD_TYPE_INPUT => [
            'name' => 'Строка',
            'type' => 'text',
            'id' => self::FIELD_TYPE_INPUT
        ],
        self::FIELD_TEXTAREA => [
            'name' => 'Описание',
            'type' => 'textarea',
            'id' => self::FIELD_TEXTAREA
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
            'type' => 'city',
            'id' => self::FIELD_TYPE_TOWN
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
        self::FIELD_TYPE_DATE => [
            'name' => 'Дата',
            'type' => 'date',
            'id' => self::FIELD_TYPE_DATE
        ],
        self::FIELD_TYPE_TEL => [
            'name' => 'Телефон',
            'type' => 'tel',
            'id' => self::FIELD_TYPE_TEL
        ]
    ];

    static array $notRequired = [self::FIELD_TYPE_CHECKBOX];
    public static bool $md5Alias = true;
    public static User|null $user = null;

    public $timestamps = true;
    protected $table = 'field';
    protected $fillable = ['id', 'name', 'field_group_id', 'site_id', 'alias', 'field_type',
        'required', 'sort_order', 'placeholder'];

    protected $appends = ['select_values', 'data'];

    public function __construct(array $attributes = [])
    {
        self::$fieldTypes[static::FIELD_TYPE_TOWN]['api_link'] = route('search.city');
        self::$fieldTypes[static::FIELD_TYPE_TOWN]['api_params'] = 'term';
        self::$fieldTypes[static::FIELD_TYPE_TOWN]['api_return_value'] = 'title_ru';

        parent::__construct($attributes);
    }

    public static function feedbackValue0($value)
    {
        return $value;
    }

    public static function feedbackValue1($value)
    {
        return $value;
    }

    public static function feedbackValue3($value)
    {
        if ((int)$value == 1) {
            return '+';
        }

        return '-';
    }

    public static function feedbackValue4($value)
    {
        $fieldValue = FieldValue::find($value);

        if ($fieldValue) {
            return $fieldValue->value;
        }

        return '-';
    }

    public static function feedbackValue5($value)
    {
        return $value;
    }

    public static function feedbackValue6($value)
    {
        return $value;
    }

    public static function feedbackValue7($value): string|null
    {
        return datetime_format($value, false);
    }

    public static function feedbackValue8($value)
    {
        return $value;
    }

    public static function feedbackValue9($value)
    {
        return $value;
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }

    public function field_values()
    {
        return $this->hasMany(FieldValue::class)->orderBy('sort_order');
    }

    public function field_group()
    {
        return $this->belongsTo(FieldGroup::class);
    }

    public function save(array $options = [])
    {
        $this->alias = $this->alias();

        parent::save($options);

        $this->saveFieldValues();
    }

    private function alias(): string
    {
        if (static::$md5Alias == true) {
            return md5($this->name . microtime(true));
        } else {
            return $this->alias;
        }
    }

    private function saveFieldValues()
    {
        $values = Request::input('values');

        if (!empty($values)) {
            $values = array_filter($values);
            foreach ($values as $value) {

                if (!empty($value['value'])) {
                    FieldValue::create([
                        'value' => $value['value'],
                        'field_id' => $this->id
                    ]);
                }
            }
        }
    }

    public function getSelectValuesAttribute()
    {
        $selectValues = [];

        foreach (static::$fieldTypes as $id => $fieldType) {

            if (!is_array($this->field_type)) {
                $fieldType = $this->field_type;
            } else {
                $fieldType = $this->field_type['id'];
            }
            if ($fieldType && $id == $fieldType) {
                $selectValues = FieldValue::whereFieldId($this->id)
                    ->orderBy('sort_order')->get();
            }
        }

        return $selectValues;
    }

    public function getFieldValue(Collection $fieldUserValues)
    {
        foreach ($fieldUserValues as $fieldUserValue) {
            if (isset($fieldUserValue->field) &&
                ($this->alias == $fieldUserValue->field->alias)) {
                return $fieldUserValue;
            }
        }
        return null;
    }

    public function getUserValues($fieldUserValues)
    {
        $this->visibility = FieldUserValue::VISIBILITY_ME;
        $this->value = null;
        $this->field_user_value_id = null;

        if (!empty($fieldUserValues)) {
            foreach ($fieldUserValues as $fieldUserValue) {

                if (isset($fieldUserValue->field) &&
                    ($this->id == $fieldUserValue->field->id)) {

                    if (isset($fieldUserValue->visibility)) {
                        $this->visibility = (int)$fieldUserValue->visibility;
                    }

                    $this->value = $this->{'prepareValue' . $this->field_type}($fieldUserValue->value);

                    $this->field_user_value_id = $fieldUserValue->id;

                    break;
                }
            }
        }

        return $this;
    }

    public function getDataAttribute()
    {
        $data['visibility'] = FieldUserValue::VISIBILITY_ME;
        $data['value'] = null;

        $fieldUserGroup = FieldUserGroup::whereFieldGroupId($this->field_group_id);

        if (self::$user) {
            $fieldUserGroup = $fieldUserGroup->whereUserId(self::$user->id);
        }

        $fieldUserGroup = $fieldUserGroup->get(['id'])->first();

        if ($fieldUserGroup) {
            $fieldUserValue = FieldUserValue::whereFieldUserGroupId($fieldUserGroup->id)
                ->whereFieldId($this->id)->with(['field'])->get();

            if (count($fieldUserValue) > 0) {
                foreach ($fieldUserValue as $userValue) {
                    if ($userValue->field->field_type == Field::FIELD_TYPE_IMAGE) {
                        $storageFile = StorageFile::find($userValue->value);

                        $data['value'][] = [
                            'title' => $storageFile->title,
                            'description' => $storageFile->description,
                            'id' => $storageFile->id,
                            'src' => $storageFile->thumbs['thumb1920x1080'],
                            'original' => $storageFile->thumbs['original'],
                            'src_miniature' => $storageFile->thumbs['thumb280x157'],
                            'url' => $storageFile->url . DS . $storageFile->filename,
                            'url_miniature' => $storageFile->thumbs['thumb1920x1080']
                        ];

                    } else {
                        $data['value'] = $userValue->value;
                    }

                    $data['visibility'] = (int)$userValue->visibility;
                }
            }
        }
        return $data;
    }

    private function prepareValue0($value)
    {
        return $value;
    }

    private function prepareValue3($value)
    {
        return $value;
    }

    private function prepareValue4($value)
    {
        return $value;
    }

    private function prepareValue5($value)
    {
        return $value;
    }

    private function prepareValue6($value)
    {
        return $value;
    }

    private function prepareValue7($value)
    {
        $dateString = null;

        if ($value) {
            $carbon = Carbon::parse($value);
            $dateString = $carbon->format(Carbon::DEFAULT_TO_STRING_FORMAT);
        }

        return $dateString;
    }

    private function prepareValue8($value)
    {
        return $value;
    }

    private function prepareValue9($value)
    {
        return $value;
    }
}
