<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModeratorsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moderators', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('key');
            $table->string('secret');
            $table->integer('user_id')->unsigned()->index();
            $table->integer('contest_id')->unsigned()->index();
            $table->timestamp('expiry');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
            $table->foreign('contest_id')->references('id')->on('contests')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::table('moderators', function ($table) {
            $table->dropIndex('moderators_contest_id_index');
            $table->dropForeign('moderators_contest_id_foreign');
            $table->dropIndex('moderators_user_id_index');
            $table->dropForeign('moderators_user_id_foreign');
        });
        Schema::drop('moderators');
    }

}
