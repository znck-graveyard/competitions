<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJudgesTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('judges', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('contest_id')->unsigned();
			$table->foreign('contest_id')->references('id')->on('contests')->onDelete('cascade');
			$table->string('name')->default('');
			$table->string('email');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
		$table->dropForeign('judges_user_id_foreign');
		$table->dropForeign('judges_contest_id_foreign');
		Schema::drop('judges');
	}

}
