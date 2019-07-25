<?php
/**
 * Created by PhpStorm.
 * User: uzielgl
 * Date: 2019-07-24
 * Time: 18:13
 */

namespace App\ForwardEngineer;

use Illuminate\Support\Str;

/**
 * Class _Namespace
 *
 * @package App\ForwardEngineer
 * @author  Uziel García <uzielgl@gmail.com>
 */
class _Class extends _Base
{
    public $properties = [];
    public $methods = [];
    public $constants = [];
    public $relations = [];
    public $traits = [];
    public $namespace;


    /**
     * @return \ReflectionClass
     *
     * @throws \ReflectionException
     */
    public function getReflector()
    {
        return new \ReflectionClass($this->getClassName());
    }

    /**
     * Add some item to the class.
     *
     * @param string   $property
     * @param TypeLine $typeLine
     *
     * @return void
     */
    public function add($property, $typeLine)
    {
        $property = Str::plural($property);
        $this->{$property}[] = $typeLine;
        return $this;
    }


    public function getClassName()
    {
        $prefix = '\\';

        if ($this->namespace) {
            $prefix .= $this->namespace->getQualifiedName();
        }

        return $prefix . '\\' . $this->name;
    }



//    public function
}
