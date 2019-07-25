<?php
/**
 * Created by PhpStorm.
 * User: uzielgl
 * Date: 2019-07-24
 * Time: 18:09
 */

namespace App\ForwardEngineer;

/**
 * Class ContainerClasses
 *
 * @package App\ForwardEngineer
 * @author  Uziel García <uzielgl@gmail.com>
 */
class ContainerClasses implements \JsonSerializable
{

    protected $namespaces = [];

    protected $classes = [];

    /**
     * Add Namespaces.
     *
     * @param TypeLine $typeLine
     *
     * @return _Namespace
     */
    public function addNamespace($typeLine)
    {
        $namespace = new _Namespace($typeLine);
        $this->namespaces[] = $namespace;

        return $namespace;
    }

    /**
     * Add a class
     *
     * @param TypeLine $typeLine
     *
     * @return _Class;
     */
    public function addClass($typeLine)
    {
        $class = new _Class($typeLine);
        $this->classes[] = $class;
        return $class;
    }

    /**
     * Set relation.
     *
     * @param TypeLine $type
     *
     * @return $this
     */
    public function setRelation($relation)
    {
        // We need to search the classes in: the container->classes and all the namespaces->classes

        foreach ($this->classes as $class) {
            $full_class_name = $class->name;
            if ($relation->connection == 'herency' and $relation->children == $full_class_name) {
                $class->relations[] = $relation;
            }
        }

        foreach ($this->namespaces as $ns) {
            foreach ($ns->classes as $class) {
                $full_class_name = $ns->name . '.' . $class->name;
                if ($relation->connection == 'herency' and $relation->children == $full_class_name) {
                    $class->relations[] = $relation;
                }
            }
        }
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
