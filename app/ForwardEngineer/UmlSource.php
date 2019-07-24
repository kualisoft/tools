<?php
/**
 * Created by PhpStorm.
 * User: uzielgl
 * Date: 2019-07-23
 * Time: 20:08
 */
namespace App\ForwardEngineer;

use Symfony\Component\Filesystem\Filesystem;

/**
 * Class UmlSource
 *
 * @package App\ForwardEngineer
 * @author  Uziel García <uzielgl@gmail.com>
 */
class UmlSource
{
    protected $fs;

    public function setFilesystem($filesystem)
    {
        $this->fs = $filesystem;
    }
}
