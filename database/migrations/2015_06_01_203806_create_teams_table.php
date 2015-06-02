<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('contest_id')->unsigned()->index();
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
        Schema::table('teams', function ($table) {
            $table->dropIndex('teams_contest_id_index');
            $table->dropForeign('teams_contest_id_foreign');
        });
        Schema::drop('teams');
    }

}
