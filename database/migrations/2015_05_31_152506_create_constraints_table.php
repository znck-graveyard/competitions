<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConstraintsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('constraints', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('contest_id')->unsigned();
            $table->string('key');
            $table->string('condition');
            $table->string('value');
            $table->boolean('optional')->default(0);
            $table->timestamps();
            $table->foreign('contest_id')
                ->refrences('id')
                ->on('contests')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('constraints');
    }

}
