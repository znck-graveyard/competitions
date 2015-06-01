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
			$table->string('name');
			$table->string('email');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->date('voted_at');
			$table->integer('voted_for_entry')->unsigned();
			$table->foreign('voted_for_entry')->references('id')->on('entries')->onDelete('cascade');

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
