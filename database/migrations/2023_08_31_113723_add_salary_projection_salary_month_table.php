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
        Schema::table('abs_salary_projection', function (Blueprint $table) {
                $table->date('payroll_months')->nullable()->after('vmt_emp_payroll_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        dropColumnIfExists('abs_salary_projection','payroll_months');
    }
};
