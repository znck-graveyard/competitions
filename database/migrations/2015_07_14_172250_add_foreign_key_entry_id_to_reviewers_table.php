<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyEntryIdToReviewersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reviewers', function (Blueprint $table) {
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
        Schema::table('reviewers', function (Blueprint $table) {

            $table->dropForeign('reviewers_user_id_foreign');
        });
    }
}
