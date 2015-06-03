<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ContestantEntry extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contestant_entry', function(Blueprint $table)
		{
			$table->increments('id');
            $table->bigInteger('entry_id')->unsigned()->index();
            $table->bigInteger('contestant_id')->unsigned()->index();
            $table->integer('votes_count')->unsigned()->default(0);
			$table->timestamps();
            $table->foreign('entry_id')->references('id')->on('entries')->onUpdate('cascade');
            $table->foreign('contestant_id')->references('id')->on('contestants')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('contestant_entry', function ($table) {
            $table->dropForeign(['entry_id']);
            $table->dropIndex(['entry_id']);
            $table->dropIndex(['contestant_id']);
            $table->dropForeign(['contestant_id']);
        });
        Schema::drop('contestant_entry');
	}

}
