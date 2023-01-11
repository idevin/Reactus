<?php


namespace App\Models\Helpers\FieldDecorator;


use App\Models\Field;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model as ModelCollection;
use Vinelab\NeoEloquent\Eloquent\Model;

class Decorator
{
    static mixed $classInstance = null;
    /**
     * @var Model
     */
    protected Model $field;
    protected mixed $value;
    protected string $class;

    /**
     * Decorator constructor.
     * @param Model|ModelCollection|Collection|null $field
     * @param ?null $value
     * @param string $class
     */
    public function __construct(Model|ModelCollection|Collection|null $field, mixed $value = null, string $class = Field::class)
    {
        $this->field = $field;
        $this->value = $value;
        $this->class = $class;
    }

    public function decorate(): mixed
    {
        return static::getClass($this->class, $this->field->field_type)->decorate($this->value, $this->field);
    }

    public static function getClass($class, $fieldType)
    {
        static::$classInstance = (new $class::$fieldTypes[$fieldType]['class']);

        return static::$classInstance;
    }

    public function save()
    {
        return static::getClass($this->class, $this->field->field_type)->save($this->value, $this->field);
    }

    public function validate()
    {
        return static::getClass($this->class, $this->field->field_type)->validate($this->value, $this->field);
    }
}