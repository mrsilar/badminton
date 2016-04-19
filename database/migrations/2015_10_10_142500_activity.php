<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Activity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('activity', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cover_img',500);
            $table->string('title',500);
            $table->integer('people_count')->unsigned();
            $table->string('postion',1000);
            $table->timestamp('start_time');
            $table->integer('cost')->unsigned();
            $table->timestamp('apply_start_time');
            $table->timestamp('apply_end_time');
            $table->timestamp('end_time');
            $table->integer('apply_type')->unsigned();//1个人 2团体
            $table->integer('min_male_count')->unsigned();
            $table->integer('min_female_count')->unsigned();
            $table->mediumText('introduction');
            $table->longText('rule');
            $table->longText('reward');//奖励
            $table->longText('points');
            $table->string('link_man',15);
            $table->string('link_mail',150);
            $table->string('link_phone',13);
            $table->string('link_qq',13);
            $table->integer('label');//1  热门  2推荐  3预告
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('activity');
    }
}
