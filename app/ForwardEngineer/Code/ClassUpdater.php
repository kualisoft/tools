<?php
/**
 * Created by PhpStorm.
 * User: uzielgl
 * Date: 2019-07-24
 * Time: 19:37
 */

namespace App\ForwardEngineer\Code;

use App\ForwardEngineer\_Class;
use App\ForwardEngineer\Utils;

/**
 * Class ClassUpdater
 *
 * @package App\ForwardEngineer\Code
 * @author  Uziel García <uzielgl@gmail.com>
 */
class ClassUpdater
{
    /**
     * @var _Class
     */
    protected $class;

    /**
     * @var \ReflectionClass
     */
    protected $reflector;

    protected $sourceFile;

    /**
     * @var string
     */
    protected $updatedSource;

    protected $updates = [];


    /**
     * Set class.
     *
     * @param _Class $class
     *
     * @return $this
     */
    public function setClass(_Class $class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Set source file.
     *
     * @param string $path
     *
     * @return $this
     */
    public function setSourceFile($path)
    {
        $this->sourceFile = $path;

        return $this;
    }

    /**
     * Update the source php coude.
     */
    public function updateCode()
    {
        require_once $this->sourceFile;

        $this->reflector = $this->class->getReflector();

        // Necesitamos checar que tenga todas las propiedades, traits, relations de la clase.

        // First the $relations. Only one relation herency.
        $relations = collect($this->class->relations);
        $herency_relation = $relations->filter(function ($item) {
            return $item->name == 'herency';
        })->first();

        if ($herency_relation) {
            $parentClass = Utils::toClassName($herency_relation->parent);

            if (!$this->reflector->getParentClass()) {
                $this->updates['set_parent'] = [
                    'class' => $parentClass
                ];
            }
        }


        $this->proccessUpdates();

    }


    public function proccessUpdates()
    {
        $this->updatedSource = $this->getSource();

        foreach ($this->updates as $key => $data) {
            if ($key == 'set_parent') {
                $this->setParentClass($data['class']);
            }
        }

        file_put_contents($this->sourceFile, $this->updatedSource);
    }

    public function setParentClass($parentClass)
    {
        $ns = $this->getNs($parentClass);

        // If the class is in the same namespace we only need to extend it.
        if (strpos($this->updatedSource, "namespace {$ns};")) {
            $this->updatedSource = str_replace(
                "class {$this->class->name}",
                "class {$this->class->name} extends {$this->getClassFromNs($parentClass)}",
                $this->updatedSource
            );
        } else { // TODO We need to check if is set yet the "use Namespace\ClassName" and if not put it.

        }
    }

    public function getSource()
    {
        return file_get_contents($this->sourceFile);
    }

    public function getNs($full_class_name)
    {
        $ns = explode('\\', $full_class_name);
        array_pop($ns);
        return implode('\\', $ns);
    }

    public function getClassFromNs($full_class_name)
    {
        $ns = explode('\\', $full_class_name);
        $class_name = array_pop($ns);
        return $class_name;
    }


}
