<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Faker\Factory as FakerFactory;
use HRTime\StopWatch;
use HRTime\Unit;
use App\Redis\Client;
use Symfony\Component\VarDumper\VarDumper;

class Faker extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hq:faker:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fake data for test.';

    /**
     *
     * @var  \Faker\Generator
     */
    protected $faker;

    /**
     *
     * @var \HRTime\StopWatch 
     */
    protected $stopWatch;

    /**
     *
     * @var \App\Redis\Client 
     */
    protected $redis;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(StopWatch $watch) {
        parent::__construct();
        $this->redis = Client::getInstance();
        $this->stopWatch = $watch;
        $this->faker = FakerFactory::create();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        for ($i = 0; $i < 1000000; $i++) {
            $userInfo = $this->faker->dayOfWeek . ":" . $this->faker->md5;
            $rank = $this->faker->latitude;
            if ($rank <= 0) {
                continue;
            }
//            $this->stopWatch->start();
            $this->redis->zadd("set:high:price:sh600097", $rank, $userInfo);
//            $this->stopWatch->stop();
//            VarDumper::dump($this->stopWatch->getLastElapsedTime(Unit:: MILLISECOND));
//            VarDumper::dump(["a" => 1]);
//            VarDumper::dump($this->redis);
//            VarDumper::dump("abc");
//            VarDumper::dump(false);
        }
    }

}
