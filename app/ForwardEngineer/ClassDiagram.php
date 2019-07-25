<?php
/**
 * Created by PhpStorm.
 * User: uzielgl
 * Date: 2019-07-23
 * Time: 20:08
 */

namespace App\ForwardEngineer;

/**
 * Class ClassDiagram
 *
 * @package App\ForwardEngineer
 * @author  Uziel García <uzielgl@gmail.com>
 */
abstract class ClassDiagram extends UmlSource
{

    protected $sourceFile;



    public function setSourceFile($source_file)
    {
        $this->sourceFile = $source_file;
    }

    public function getSource()
    {
        return file_get_contents($this->sourceFile);
    }

    public function updateCode()
    {
        $container = $this->parse();

        foreach ($container->namespaces as $ns) {
            foreach ($ns->classes as $class) {

            }
        }
    }


    /**
     * Transform the source code into and array with packages and classes.
     *
     * @return void
     */
    abstract public function getContainerClasses();
}
