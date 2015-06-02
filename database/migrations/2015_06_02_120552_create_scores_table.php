<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('scores', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('judge_id')->unsigned();
			$table->foreign('judge_id')->references('id')->on('judges')->onDelete('cascade');
			$table->integer('contest_id')->unsigned();
			$table->foreign('contest_id')->references('id')->on('contests')->onDelete('cascade');
			$table->integer('entry_id')->unsigned();
			$table->foreign('entry_id')->references('id')->on('entries')->onDelete('cascade');
			$table->decimal('value');
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
		Schema::table('scores', function(Blueprint $table) {
			$table->dropForeign(['judge_id']);
			$table->dropForeign(['contest_id']);
			$table->dropForeign(['entry_id']);
		});
		Schema::drop('scores');
	}

}
