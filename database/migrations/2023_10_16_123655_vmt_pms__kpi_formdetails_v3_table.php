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
        Schema::create('vmt_pms_kpiform_details_v3', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vmt_pms_kpiform_v3_id');
            $table->text('objective_values');
            $table->timestamps();

            $table->foreign('vmt_pms_kpiform_v3_id')->references('id')->on('vmt_pms_Kpiform_v3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vmt_pms_kpiform_details_v3');
    }
};
