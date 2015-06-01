<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reviewers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('contest_id')->unsigned();
			$table->foreign('contest_id')->references('id')->on('contests')->onDelete('cascade');
			$table->integer('user_id')->nullable();
			$table->timestamp('voted_at');
			$table->integer('entry_id')->unsigned();
			$table->foreign('entry_id')->references('id')->on('entries')->onDelete('cascade');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{	
		$table->dropForeign('reviewers_user_id_foreign');
		$table->dropForeign('reviewers_contest_id_foreign');
		Schema::drop('reviewers');
	}

}
