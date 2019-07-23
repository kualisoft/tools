<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class MakeUmlClassDiagram extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:uml:class_diagram {directory} {outputFile?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $cd = getcwd() . '/';

        $directory = $cd . $this->argument('directory');
        $directory = realpath($directory);
        dump($directory);

        $outputfile = $this->argument('outputFile');
        if (!$outputfile) {
            $name = $this->argument('directory');
//            $name = explode('/', $directory);
//            $name = end($name);
            $outputfile = $cd . 'documentation/class_diagrams/' . $name . '.puml';
        } else {
            $outputfile = $cd . $outputfile;
        }

        // Create the directory if don't exists
        $output_dir = explode('/', $outputfile);
        array_pop($output_dir);
        $output_dir = implode('/', $output_dir);
        if (!is_dir($output_dir))
            mkdir($output_dir, 0777, true);

        dump($outputfile);

        $process = new Process(['umlwriter', 'diagram:render', '--processor=plantuml', $directory]);
        $process->run();

        $diagram_code = $process->getOutput();

        file_put_contents($outputfile, $diagram_code);

//        umlwriter diagram:render --processor=plantuml ./app/ > temp1.txt
//plantuml -Tpng temp1.txt -o /tmp
    }
}
