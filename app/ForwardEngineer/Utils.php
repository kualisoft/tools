<?php
/**
 * Created by PhpStorm.
 * User: uzielgl
 * Date: 2019-07-24
 * Time: 20:24
 */

namespace App\ForwardEngineer;

/**
 * Class Utils
 *
 * @package App\ForwardEngineer
 * @author  Uziel García <uzielgl@gmail.com>
 */
class Utils
{

    /**
     * @param $class
     * @return mixed
     */
    public static function toClassName($class)
    {
        return str_replace('.', '\\', $class);
    }
}
