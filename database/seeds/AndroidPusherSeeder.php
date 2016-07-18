<?php

use Illuminate\Database\Seeder;
use AFM\Rsync\Rsync;
use Alchemy\Zippy\Zippy;

//use Redis;

class AndroidPusherSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
//        DB::table("android_push_datas");


        $rsync = new Rsync;
        $dir = "/tmp/testt/";
        $file = "finance_achieve-rate.tgz";
        $rsync->sync("rsync://10.55.37.56/gaoming_tmp/{$file}", $dir);
        $filename = "{$dir}{$file}";
        if (file_exists($filename)) {
            $zippy = Zippy::load();
            $archive = $zippy->open($filename);
            foreach ($archive as $member) {
                $location = $member->getLocation();
                $date = str_replace(["finance", ".dat"], ["", ""], $location);
                $member->extract($dir);
                $data = file("{$dir}/{$location}");
                $data = array_reverse($data);
                foreach ($data as $line => $row) {
                    $row = trim($row);
                    $matches = [];
                    if ($line === 0) {
                        preg_match_all('/(?P<name>\w+[\ |\-]\w+): (?P<num>\w+)/', $row, $matches);
                        $arr = ["date" => $date];
                        foreach ($matches["name"] as $k => $name) {
                            switch ($name) {
                                case "news total":
                                    $arr["registers"] = $matches["num"][$k];
                                    break;
                                case "push total":
                                    $arr["push"] = $matches["num"][$k];
                                    break;
                                case "achieve-rate":
                                    $arr["average_rate"] = $matches["num"][$k];
                                    break;
                                default:
                                    break;
                            }
                        }
                        try {
                            DB::table("android_push_datas")->insert($arr);
                        } catch (\Exception $e) {
                            echo $e->getMessage() . "\n";
                        }
                    } else {
                        continue;
                    }
                }
                unlink("{$dir}/{$location}");
            }
        }
        unlink($filename);
    }

}
