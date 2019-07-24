<?php
/**
 * Created by PhpStorm.
 * User: uzielgl
 * Date: 2019-07-23
 * Time: 19:34
 */

namespace Tests\Unit\Code;

use App\ForwardEngineer\PlantUml\ClassDiagram;
use Symfony\Component\Filesystem\Filesystem;
use Tests\TestCase;

/**
 * Class UpdateTest
 *
 * @package Tests\Unit\Code
 * @author  Uziel García <uzielgl@gmail.com>
 */
class UpdateTest extends TestCase
{

    /**
     * Test
     */
    public function testUpdate()
    {
        $plant_uml_file = '/Users/uzielgl/apps/kualisoft/documentation/class_diagrams/app/Http.puml';

        $classDiagram = new ClassDiagram();
        $classDiagram->setFilesystem(new Filesystem());

        $classDiagram->setSourceFile($plant_uml_file);


        $classDiagram->parse();




        $this->assertEquals(true, true);
    }
}
