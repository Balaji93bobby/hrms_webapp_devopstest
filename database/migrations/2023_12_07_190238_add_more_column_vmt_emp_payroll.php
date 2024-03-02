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

            if (!Schema::hasColumn('vmt_emp_payroll', 'payslip_release_date')) {
                $table->text('payslip_release_date')->nullable()->after('is_payslip_released');
            }
            if (!Schema::hasColumn('vmt_emp_payroll', 'is_payslip_sent')) {
                $table->text('is_payslip_sent')->nullable()->default(0)->after('payslip_release_date');
            }
            if (!Schema::hasColumn('vmt_emp_payroll', 'payslip_sent_date')) {
                $table->text('payslip_sent_date')->nullable()->after('is_payslip_sent');
            }

            if (!Schema::hasColumn('vmt_emp_payroll', 'taxslip_release_date')) {
                $table->text('taxslip_release_date')->nullable()->after('is_taxsheet_released');
            }
            if (!Schema::hasColumn('vmt_emp_payroll', 'is_taxslip_sent')) {
                $table->text('is_taxslip_sent')->nullable()->default(0)->after('taxslip_release_date');
            }
            if (!Schema::hasColumn('vmt_emp_payroll', 'taxslip_sent_date')) {
                $table->text('taxslip_sent_date')->nullable()->after('is_taxslip_sent');
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

            $table->dropColumn('payslip_release_date');
            $table->dropColumn('is_payslip_sent');
            $table->dropColumn('taxslip_release_date');
            $table->dropColumn('is_taxslip_sent');
            $table->dropColumn('payslip_sent_date');
            $table->dropColumn('taxslip_sent_date');
        });
    }
};
