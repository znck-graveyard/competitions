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
		Schema::table('judges', function(Blueprint $table) {
			$table->dropForeign('judges_judge_id_foreign');
			$table->dropForeign('judges_contest_id_foreign');
			$table->dropForeign('judges_entry_id_foreign');
		});
		Schema::drop('reviewers');
	}

}
