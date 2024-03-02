<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vmt_time_period', function (Blueprint $table) {
            $table->increments('id');
            $table->text('type');
            $table->date('start_month');
            $table->date('end_month');
            $table->text('abbrevation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vmt_time_period', function (Blueprint $table) {
            Schema::dropIfExists('vmt_time_period');
        });
    }
};
