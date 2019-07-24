<?php
/**
 * Created by PhpStorm.
 * User: uzielgl
 * Date: 2019-07-24
 * Time: 18:13
 */

namespace App\ForwardEngineer;

/**
 * Class _Namespace
 *
 * @package App\ForwardEngineer
 * @author  Uziel García <uzielgl@gmail.com>
 */
class _Namespace extends _Base
{

    public $classes = [];

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
}
