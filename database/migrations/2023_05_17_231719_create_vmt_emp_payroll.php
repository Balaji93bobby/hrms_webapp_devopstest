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
        Schema::create('vmt_emp_payroll', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payroll_id')->constrained('vmt_payroll');
            $table->foreignId('user_id')->constrained('users');
            $table->integer('is_payslip_released');
            $table->integer('is_taxsheet_released');
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
        Schema::dropIfExists('vmt_emp_payroll');
    }
};
