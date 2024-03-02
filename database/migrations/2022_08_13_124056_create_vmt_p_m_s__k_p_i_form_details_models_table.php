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
        Schema::create('vmt_pms_kpiform_details', function (Blueprint $table) {
            $table->id();
            $table->text('vmt_pms_kpiform_id');
            $table->text('dimension')->nullable();
            $table->text('kpi')->nullable();
            $table->text('operational_definition')->nullable();
            $table->text('measure')->nullable();
            $table->text('frequency')->nullable();
            $table->text('target')->nullable();
            $table->text('stretch_target')->nullable();
            $table->text('source')->nullable();
            $table->text('kpi_weightage')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vmt_pms_kpiform_details');
    }
};
