<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateJudgesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('judges', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contest_id')->unsigned();
            $table->integer('user_id')->unsigned()->nullable();

            $table->string('name');
            $table->string('email');
            $table->string('token', 36);

            $table->timestamps();

            $table->foreign('contest_id')->references('id')->on('contests')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('judges', function (Blueprint $table) {
            $table->dropForeign('judges_user_id_foreign');
            $table->dropForeign('judges_contest_id_foreign');
        });

        Schema::drop('judges');
    }

}
