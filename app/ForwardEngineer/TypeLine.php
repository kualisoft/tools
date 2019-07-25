<?php
/**
 * Created by PhpStorm.
 * User: uzielgl
 * Date: 2019-07-24
 * Time: 18:01
 */

namespace App\ForwardEngineer;

/**
 * Class TypeLine
 *
 * @package App\ForwardEngineer
 * @author  Uziel García <uzielgl@gmail.com>
 */
class TypeLine implements \JsonSerializable
{
    public $type;
    public $name;
    public $visibility;

    // For relations types.
    public $parent;
    public $children;

    /**
     * TypeLine constructor.
     *
     * @param array $array
     */
    public function __construct($array)
    {
        foreach ($array as $type => $value) {
            $this->{$type} = $value;
        }
    }

    /**
     * Determines if is some type (class, trait, method, property, constant, namespace, relation, closeTag)
     *
     * @param string $type
     *
     * @return bool
     */
    public function is(...$types)
    {
        return in_array($this->type, $types);
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
