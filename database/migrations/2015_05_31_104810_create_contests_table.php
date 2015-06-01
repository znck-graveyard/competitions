<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContestsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->string('name');
            $table->text('description');
            $table->string("submission_type");
            $table->string('image')->nullable();
            $table->text('rules');
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->string("prize");
            $table->boolean('peer_review_enabled');
            $table->decimal('peer_review_weightage')->nullable();
            $table->boolean('manual_review_enabled');
            $table->decimal('manual_review_weightage')->nullable();
            $table->integer('maintainer_id')->unsigned();
            $table->integer('max_entries');
            $table->integer('max_iteration');
            $table->boolean('team_entry_enabled')->default(false);
            $table->integer('team_size');
            $table->timestamps();
            $table->foreign('maintainer_id')
                ->refrences('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contests', function ($table) {
            $table->dropForeign('contests_maintainer_id_foreign');
        });
        Schema::drop('contests');

    }

}
