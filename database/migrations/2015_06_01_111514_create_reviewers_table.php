<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReviewersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviewers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contest_id')->unsigned();
            $table->integer('user_id')->nullable();
            $table->timestamp('voted_at');
            $table->integer('entry_id')->unsigned();

            $table->foreign('contest_id')->references('id')->on('contests')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reviewers', function (Blueprint $table) {

            $table->dropForeign('reviewers_contest_id_foreign');
        });
        Schema::drop('reviewers');
    }

}
