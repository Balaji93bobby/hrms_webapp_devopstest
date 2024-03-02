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
        Schema::create('vmt_attendance_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('is_sandwich_applicable')->default('0');
            $table->integer('is_weekoff_applicable')->default('0');
            $table->integer('is_holiday_applicable')->default('0');
            $table->integer('can_consider_approved_leaves')->default('0');
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
        Schema::dropIfExists('vmt_attendance_settings');
    }
};
