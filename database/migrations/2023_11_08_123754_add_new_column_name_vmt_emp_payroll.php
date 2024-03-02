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
        Schema::table('vmt_emp_payroll', function (Blueprint $table) {
            //
            if (!Schema::hasColumn('vmt_emp_payroll', 'payslip_revoked_date')) {
                $table->text('payslip_revoked_date')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vmt_emp_payroll', function (Blueprint $table) {
            //
            if (Schema::hasColumn('vmt_emp_payroll', 'payslip_revoked_date')) {
                $table->dropColumn('payslip_revoked_date');
            }
        });
    }
};
