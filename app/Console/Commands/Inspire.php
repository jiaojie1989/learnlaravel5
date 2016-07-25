<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

class Inspire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inspire1';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display an inspiring quote';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
//        sleep(50);
        $pid = pcntl_fork();
        if ($pid) {
            var_dump("Succ Child");
            var_dump($pid);
            exit();
        } else {
            var_dump("Erro Child");
            var_dump($pid);
            exit;
        }
        $this->comment(PHP_EOL.Inspiring::quote().PHP_EOL);
    }
}
