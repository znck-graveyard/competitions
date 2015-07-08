<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContestWinnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contest_winners', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contest_id')->index();
            $table->integer('position')->unsigned();
            $table->integer('winnerable_id')->unsigned();
            $table->string('winnerable_type');
            $table->timestamps();
            $table->foreign('contest_id')->references('id')->on('contests')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contest_winners', function ($table) {
            $table->dropForeign(['contest_id']);
            $table->dropIndex(['contest_id']);
        });
        Schema::drop('contest_winners');
    }
}
