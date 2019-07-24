<?php
/**
 * Created by PhpStorm.
 * User: uzielgl
 * Date: 2019-07-23
 * Time: 20:09
 */

namespace App\ForwardEngineer\PlantUml;

use App\ForwardEngineer\ClassDiagram as BaseClassDiagram;
use App\ForwardEngineer\ContainerClasses;
use App\ForwardEngineer\TypeLine;

/**
 * Class ClassDiagram
 *
 * @package App\ForwardEngineer\PlantUml
 * @author  Uziel García <uzielgl@gmail.com>
 */
class ClassDiagram extends BaseClassDiagram
{



    /**
     * Parse
     *
     * @return void
     */
    public function parse()
    {
        $source = $this->getSource();
        $lines = explode("\n", $source);

        $container = new ContainerClasses();
        $ns = null;
        $class = null;


        foreach ($lines as $line) {
            $type = $this->detectType($line);
            if ($type) {
                if ($type->is('namespace')) {
                    $ns = $container->addNamespace($type);
                } elseif ($type->is('class')) {
                    $class = $ns->addClass($type);
                } elseif ($type->is('trait', 'method', 'property', 'constant')) {
                    $class->add($type->type, $type);
                } elseif ($type->is('relation')) {

                }
            }
        }
        
    }

    /**
     * Detect the type of line.
     *
     * @param string $input_line
     *
     * @return array
     */
    public function detectType($input_line)
    {
        $return = [];
        $visibilities = [
            '#' => 'protected',
            '+' => 'public',
            '-' => 'private',
        ];

        // Namespace
        preg_match('/namespace ([\w.]*).* {/', $input_line, $output_array);
        if ($output_array) {
            $return = [
                'type' => 'namespace',
                'name' => $output_array[1],
            ];
        }

        // Class
        preg_match('/class (.*?) << class >> {/', $input_line, $output_array);
        if ($output_array) {
            $return = [
                'type' => 'class',
                'name' => $output_array[1],
            ];
        }

        // Trait
        preg_match('/class ([\w.]*).*trait.* {/', $input_line, $output_array);
        if ($output_array) {
            $return = [
                'type' => 'trait',
                'name' => $output_array[1],
            ];
        }

        // Method
        preg_match('/([\#\-\+])([\w]*)\(\)/', $input_line, $output_array);
        if ($output_array) {
            $return = [
                'type' => 'method',
                'name' => $output_array[2],
                'visibility' => $visibilities[$output_array[1]]
            ];
        }

        // Property
        preg_match('/([\#\-\+])([\w]*)/', $input_line, $output_array);
        if (!$return and $output_array) {
            $type = 'property';
            if ($output_array[2] == strtoupper($output_array[2])) {
                $type = 'constant';
            }

            $return = [
                'type' => $type,
                'name' => $output_array[2],
                'visibility' => $visibilities[$output_array[1]]
            ];
        }

        // Herency Relation
        preg_match('/([\w.]*)\s?--\|>\s?(.*)/', $input_line, $output_array);
        if ($output_array) {
            $return = [
                'type' => 'relation',
                'connection' => 'herency',
                'parent' => $output_array[2],
                'children' => $output_array[1]
            ];
        }

        // Close Tag
        preg_match('/\}/', $input_line, $output_array);
        if ($output_array) {
            $return = [
                'type' => 'closeTag',
            ];
        }

        if ($return) {
            return new TypeLine($return);
        }


        return $return;
    }
}
