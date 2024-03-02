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
        Schema::create('vmt_org_time_period', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vmt_time_period_id');
            $table->date('year');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vmt_org_time_period', function (Blueprint $table) {
            //
        });
    }
};
