<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class TeamMember extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('team_member', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('phone_number', 13);
            $table->string('identity_card', 30)->unique();;
            $table->integer('sex'); //0未知  1 男  2女
            $table->integer('is_captain'); //0否 1是
            $table->integer('is_backup'); //0否  1是
            $table->integer('team_id'); 
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
        Schema::drop('team_member');
    }
}
