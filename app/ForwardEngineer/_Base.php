<?php
/**
 * Created by PhpStorm.
 * User: uzielgl
 * Date: 2019-07-24
 * Time: 18:18
 */

namespace App\ForwardEngineer;

use Illuminate\Http\Resources\DelegatesToResource;

/**
 * Class _Base
 *
 * @package App\ForwardEngineer
 * @author  Uziel García <uzielgl@gmail.com>
 */
class _Base implements \JsonSerializable
{
    use DelegatesToResource;

    public $resource;

    /**
     * _Namespace constructor.
     *
     */
    public function __construct($typeLine)
    {
        $this->resource = $typeLine;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    public function getQualifiedName()
    {
        return str_replace('.', '\\', $this->name);
    }
}
