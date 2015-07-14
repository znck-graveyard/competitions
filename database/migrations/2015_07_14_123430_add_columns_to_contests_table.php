<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToContestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contests', function (Blueprint $table) {
            $table->string('prize_1')->default('');
            $table->string('prize_2')->default('');
            $table->string('prize_3')->default('');
            $table->string('admin_token', 60)->nullable();;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contests', function (Blueprint $table) {
            $table->dropColumn('admin_token');
            $table->dropColumn('prize_3');
            $table->dropColumn('prize_2');
            $table->dropColumn('prize_1');
        });
    }
}
