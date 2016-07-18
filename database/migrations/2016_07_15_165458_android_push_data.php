<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AndroidPushData extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('android_push_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->date("date");
            $table->bigInteger("registers");
            $table->bigInteger("push");
            $table->decimal("average_rate");
            $table->timestamps();
            $table->unique("date");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
    }

}
