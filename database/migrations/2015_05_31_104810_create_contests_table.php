<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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

            $table->string('contest_type');
            $table->string('name');
            $table->text('description');

            $table->string('image')->nullable();

            $table->boolean('public')->default(false);

            $table->string("submission_type");
            $table->text('rules');

            $table->double("prize");
            $table->string('prize_description')->nullable();

            $table->boolean('peer_review_enabled');
            $table->decimal('peer_review_weightage')->nullable();

            $table->boolean('manual_review_enabled');
            $table->decimal('manual_review_weightage')->nullable();

            $table->integer('maintainer_id')->unsigned();

            $table->integer('max_entries');
            $table->integer('max_iteration');

            $table->integer('team_size')->nullable();
            $table->boolean('team_entry_enabled')->default(false);

            $table->integer('page_view')->default(0);

            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->timestamps();

            $table->foreign('maintainer_id')
                ->references('id')
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
