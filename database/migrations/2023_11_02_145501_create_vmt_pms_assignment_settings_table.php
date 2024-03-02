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
        Schema::create('vmt_pms_assignment_settings_v3', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->text('calendar_type');
            $table->text('year');
            $table->text('frequency');
            $table->text('pms_rating_card');
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('vmt_client_master');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vmt_pms_assignment_settings_v3');
    }
};
