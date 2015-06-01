<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContestantsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contestants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned()->index();
            $table->integer('contest_id')->unsigned()->index();
            $table->timestamps();
            $table->foreign('user_id')
                ->refrences('id')
                ->on('users')
                ->onUpdate('cascade');
            $table->foreign('contest_id')
                ->refrences('id')
                ->on('contests')
                ->onDelete('cascade')->onUpdate('cascade');
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
            $table->dropIndex('contestants_contest_id_index');
            $table->dropForeign('contestants_contest_id_foreign');
            $table->dropIndex('contestants_user_id_index');
            $table->dropForeign('contestants_user_id_foreign');
        });

        Schema::drop('contestants');
    }

}
