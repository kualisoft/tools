<?php
/**
 * Created by PhpStorm.
 * User: uzielgl
 * Date: 2019-07-23
 * Time: 18:49
 */

namespace App\Console;


class KernelTools extends Kernel
{

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\MakeUmlClassDiagram::class
    ];


    protected function getArtisan()
    {
        if (is_null($this->artisan)) {
            return $this->artisan = (new Application($this->app, $this->events, $this->app->version()))
                ->resolveCommands($this->commands);
        }
        return $this->artisan;
    }
}
