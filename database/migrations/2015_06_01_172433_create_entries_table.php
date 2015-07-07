<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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
            $table->string('uuid', 36)->index();
            $table->string('title');
            $table->text('abstract');
            $table->string('filename')->nullable();
            $table->string('file_type')->nullable();
            $table->decimal('file_size')->nullable();

            $table->boolean('is_team_entry')->default(false);

            $table->integer('contest_id')->unsigned()->index();
            $table->integer('entryable_id')->unsigned();
            $table->string('entryable_type')->unsigned();

            $table->double('score')->default(0);
            $table->integer('views')->default(0);
            $table->integer('upvotes')->default(0);
            $table->integer('downvotes')->default(0);

            $table->boolean('moderated')->default(false);
            $table->text('moderation_comment')->nullable();

            $table->timestamps();
            $table->foreign('contest_id')->references('id')->on('contests')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entries', function ($table) {
            $table->dropIndex('entries_contest_id_index');
            $table->dropForeign('entries_contest_id_foreign');
            $table->dropIndex(['uuid']); // Drop basic index in 'uuid' from 'entries' table
        });
        Schema::drop('entries');
    }

}
