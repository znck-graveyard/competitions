<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModeratorContestant extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('moderator_contestant', function(Blueprint $table)
		{
			$table->increments('id');
            $table->bigInteger('entry_id')->unsigned();
            $table->integer('moderator_id')->unsigned();
			$table->timestamps();
            $table->foreign('entry_id')->references('id')->on('entries')->onUpdate('cascade');
            $table->foreign('moderator_id')->references('id')->on('moderators')->onUpdate('cascade');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('moderator_contestant', function ($table) {
            $table->dropForeign(['entry_id']);
            $table->dropForeign(['moderator_id']);
        });
        Schema::drop('moderator_contestant');
	}

}
