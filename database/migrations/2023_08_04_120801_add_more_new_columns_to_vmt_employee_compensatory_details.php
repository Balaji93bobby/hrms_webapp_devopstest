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
        Schema::table('vmt_employee_compensatory_details', function (Blueprint $table) {
            //
            if (!Schema::hasColumn('vmt_employee_reimbursements', 'vda')) {
                $table->text('vda')->after('net_income');
            }
            if (!Schema::hasColumn('vmt_employee_reimbursements', 'vehicle_reimbursement')) {
                $table->text('vehicle_reimbursement')->after('vda');
            }
            if (!Schema::hasColumn('vmt_employee_reimbursements', 'unifrom_allowance')) {
                $table->text('unifrom_allowance')->after('education_allowance');
            }
            if (!Schema::hasColumn('vmt_employee_reimbursements', 'employer_lwf')) {
                $table->text('employer_lwf')->after('labour_welfare_fund');
            }
            if (!Schema::hasColumn('vmt_employee_reimbursements', 'employee_lwf')) {
                $table->text('employee_lwf')->after('employer_lwf');
            }
            if (!Schema::hasColumn('vmt_employee_reimbursements', 'employer_insurance')) {
                $table->text('employer_insurance')->after('insurance');
            }
            if (!Schema::hasColumn('vmt_employee_reimbursements', 'employee_insurance')) {
                $table->text('employee_insurance')->after('employer_insurance');
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
        Schema::table('vmt_employee_compensatory_details', function (Blueprint $table) {
            //
            $table->dropColumn('vda');
            $table->dropColumn('vehicle_reimbursement');
            $table->dropColumn('unifrom_allowance');
            $table->dropColumn('employer_lwf');
            $table->dropColumn('employee_lwf');
            $table->dropColumn('employer_insurance');
            $table->dropColumn('employee_insurance');
        });
    }
};
