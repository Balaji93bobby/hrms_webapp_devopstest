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
        Schema::create('vmt_assinged_holidays', function (Blueprint $table) {
            $table->id();
            $table->foreignId('holiday_list_id')->constrained('vmt_holiday_list');
            $table->foreignId('holiday_id')->constrained('vmt_holidays');
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
        Schema::dropIfExists('vmt_assinged_holidays');
    }
};
