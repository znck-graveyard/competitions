<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('username');
			$table->string('email')->unique();
			$table->string('first_name');
			$table->string('last_name')->nullable();
			$table->enum('gender',array('MALE','FEMALE'))->default('MALE');
			$table->string('password', 60);
			$table->timestamp('date_of_birth')->nullable();
			$table->boolean('is_maintainer');
			$table->date('created_at');
			$table->date('updated_at');
			$table->date('deleted_at')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
