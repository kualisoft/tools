<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Filesystem\Filesystem;

class MakeUmlClassDiagram extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:uml:class_diagram 
                                {directory : Directory to get the PHP code}
                                {outputFile? : A path to save the plantUml file (by default will be store it in ./documentation/class_diagrams/) }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create plant uml source code from some PHP directory.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $fs = new Filesystem();
        $directory_param = rtrim($this->argument('directory'), '/');
        $cd = getcwd() . '/';

        $directory = $cd . $directory_param;
        $directory = realpath($directory);

        $outputfile = $this->argument('outputFile');

        if (!$outputfile) { // We put the puml in the documentation directory.
            $name = $directory_param;
            $outputfile = $cd . 'documentation/class_diagrams/' . $name . '.puml';
        } else {
            $outputfile = $cd . $outputfile;
        }

        // Create the directory if don't exists
        $output_dir = explode('/', $outputfile);
        array_pop($output_dir);
        $output_dir = implode('/', $output_dir);
        if (!is_dir($output_dir))
            $fs->mkdir($output_dir, 0777);

        $process = new Process(['umlwriter', 'diagram:render', '--processor=plantuml', $directory]);
        $process->run();

        $diagram_code = $process->getOutput();

        $fs->dumpFile($outputfile, $diagram_code);

        // umlwriter diagram:render --processor=plantuml ./app/ > temp1.txt
        // plantuml -Tpng temp1.txt -o /tmp
    }
}
