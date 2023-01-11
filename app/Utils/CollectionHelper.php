<?php


namespace App\Utils;


use App\Models\Helpers\Model;
use Exception;
use Illuminate\Support\Collection;

abstract class CollectionHelper
{
    /**
     * @var Collection
     */
    protected static $collection;
    protected static string $collectionClassname;
    protected static $fillable = [];

    /**
     * @param $collection
     */
    public static function setCollection($collection)
    {
        static::$collection = $collection;
    }

    public static function setFillable($paramName)
    {
        static::$fillable[] = $paramName;
    }

    public static function isFillable($paramName)
    {
        return array_search($paramName, static::$fillable);
    }

    /**
     * @return Collection
     */
    public static function getCollection()
    {
        if (!static::$collection) {
            static::setCollection(new Collection());
        }
        return static::$collection;
    }

    /**
     * @param array $array
     * @return Collection
     * @throws Exception
     */
    public static function collect(array $array = [])
    {

            $collectionArray = [];
            foreach ($array as $item) {
                if (is_array($item) && static::$collectionClassname) {
                    $o = new static::$collectionClassname($item);
                    if (isset($item['id'])) {
                        if(method_exists($o,'forceFill')) $o->forceFill(['id' => $item['id']]);
                    }
                    $collectionArray[] = $o;
                } elseif(is_array($item)) {
                    $collectionArray[] = collect($item);
                }else{
                    $collectionArray = &$array;
                }
            }

        static::setCollection(collect($collectionArray));
        return static::getCollection();
    }

    /**
     * @param $key
     * @param $value
     * @return Collection
     */
    public static function getWhere($key, $value)
    {
        $collection = static::getCollection();
        return $collection->filter(function ($o) use ($collection, $key, $value) {
            return $o->$key == $value;
        });
    }

    public static function all()
    {
        return static::getCollection();
    }

    public static function addElementCollection($o)
    {
        return static::getCollection()->push($o);
    }

    /**
     * @param $key
     * @param $value
     * @return Collection
     */
    public static function addElementMap($key, $value)
    {
        $o = new StdClass();
        $o->$key = $value;
        static::addElementCollection($o);
        return static::getCollection();
    }

    public static function newClass($className)
    {
        if (class_exists($className)) {
            $newClass = get_class($className);
        } else {
            $newClass = new class() extends Model {
                protected static $collectionClassname = '\App\Models\Helpers\Model';
            };
            $newClassName = get_class($newClass);
            class_alias($newClassName, $className);
            $newClass = $className;
        }
        return $newClass;
    }

    public static function _new($array = null)
    {
        try {
            return static::collect($array);
        } catch (Exception $e) {
            return null;
        }
    }
}