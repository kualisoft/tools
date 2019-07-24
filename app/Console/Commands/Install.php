<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:bin';

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
        $filesystem = new Filesystem();

        $filesystem->symlink(getcwd() . '/tools.php', '/usr/local/bin/kualisoft');
        $filesystem->symlink(getcwd() . '/tools.php', '/usr/local/bin/ks');
    }
}
