<?php

namespace App\Traits;

trait Moderation
{
    public function getObjectType()
    {
        $data = null;
        foreach (static::$types as $type) {
            if ($type == $this->object) {
                $method = static::getMethod($this->object);
                $data = $this->$method($this->object_id);
                break;
            }
        }
        return $data;
    }

    /**
     * @param $object
     * @return mixed|string
     */
    public static function getMethod($object)
    {
        $type = preg_split('/\\\/', strtolower($object));
        return $type[count($type) - 1];
    }
}