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
        Schema::create('vmt_employee_workshifts', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('work_shift_id');
            $table->integer('is_active');
            $table->integer('flexi_shift_status');
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
        Schema::dropIfExists('vmt_employee_workshifts');
    }
};
