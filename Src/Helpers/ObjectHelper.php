<?php
/**
 * Created by PhpStorm.
 * User: abmes
 * Date: 15.09.2019
 * Time: 10:18
 */

namespace App\Helpers;


class ObjectHelper
{
    public static function hydrate($object, array $data, array $fields)
    {
        foreach ($fields as $field) {
            $method = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $field)));
            if (!($field == "id" && $data[$field] == "")){
                $object->$method($data[$field]);
            }
        }
    }

    public static function ObjectToArray($entity)
    {
        return (object)$entity;
    }
}