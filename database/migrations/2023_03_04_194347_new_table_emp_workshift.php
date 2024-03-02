<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vmt_employee_workshifts', function (Blueprint $table){
        $table->id();
        $table->integer('user_id');
        $table->integer('work_shift_id');
        $table->integer('is_active');

        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vmt_employee_workshifts');
    }
};
