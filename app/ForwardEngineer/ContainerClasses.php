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
class ContainerClasses
{

    protected $namespaces = [];

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
}
