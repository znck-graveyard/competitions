<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contests',function(Blueprint $table)
		{
            $prize=[];
            $submission_type=[];
			$table->increments('id');
            $table->string('type');
            $table->string('name');
            $table->text('description');
            $table->enum("submission_type",$submission_type);
            $table->string('image');
            $table->longText('rules');
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->enum("prize",$prize);
            $table->boolean('peer_review_enabled');
            $table->decimal('peer_review_weightage');
            $table->boolean('manual_review_enabled',5,2);
            $table->decimal('manual_review_weightage',5,2);
            $table->foreign('maintainer_id')->refrences('id')->on('users');
            $table->integer('max_entries');
            $table->time('max_iteration');
            $table->boolean('team_entry_enabled');
            $table->integer('team_size');
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
		Schema::drop('contests');
	}

}
