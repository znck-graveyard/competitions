<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntriesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('abstract');
            $table->string('filename');
            $table->string('file_type');
            $table->decimal('file_size');
            $table->integer('contest_id')->unsigned()->index();
            //$table->integer('user_id')->unsigned()->index();
            $table->boolean('is_team_entry')->default(false);
            $table->integer('entryable_id')->unsigned();
            $table->string('entryable_type')->unsigned();
            //$table->integer('team_id')->unsigned();
            $table->timestamps();
            $table->foreign('contest_id')->refrences('id')->on('contests')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contestants', function ($table) {
            $table->dropIndex('entries_contest_id_index');
            $table->dropForeign('entries_contest_id_foreign');
            $table->dropIndex('entries_user_id_index');
            //$table->dropForeign('entries_user_id_foreign');
        });
        Schema::drop('entries');
    }

}
