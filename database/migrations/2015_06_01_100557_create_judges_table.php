<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJudgesTable extends Migration {

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
			$table->string('name');
			$table->string('email');
			$table->integer('user_id')->unsigned();
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
		Schema::table('judges', function(Blueprint $table)
		{
			$table->dropForeign('judges_user_id_foreign');
			$table->dropForeign('judges_contest_id_foreign');
		});

		Schema::drop('judges');
	}

}
