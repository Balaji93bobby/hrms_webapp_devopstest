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
            if (!Schema::hasColumn('vmt_employee_compensatory_details', 'washing_allowance')) {
                $table->text('washing_allowance')->nullable()->after('other_allowance');
            }
            if (!Schema::hasColumn('vmt_employee_compensatory_details', 'driver_salary')) {
                $table->text('driver_salary')->nullable()->after('washing_allowance');
            }
            if (!Schema::hasColumn('vmt_employee_compensatory_details', 'fuel_reimbursement')) {
                $table->text('fuel_reimbursement')->nullable()->after('driver_salary');
            }
            if (!Schema::hasColumn('vmt_employee_compensatory_details', 'vpf_employee')) {
                $table->text('vpf_employee')->nullable()->after('driver_salary');
            }
            if (!Schema::hasColumn('vmt_employee_compensatory_details', 'conveniance')) {
                $table->text('conveniance')->nullable()->after('vpf_employee');
            }
            if (!Schema::hasColumn('vmt_employee_compensatory_details', 'employer_lwf')) {
                $table->text('employer_lwf')->nullable()->after('labour_welfare_fund');
            }
            if (!Schema::hasColumn('vmt_employee_compensatory_details', 'employee_lwf')) {
                $table->text('employee_lwf')->nullable()->after('employer_lwf');
            }
            if (!Schema::hasColumn('vmt_employee_compensatory_details', 'vehicle_reimbursement')) {
                $table->text('vehicle_reimbursement')->nullable()->after('employee_lwf');
            }
            if (!Schema::hasColumn('vmt_employee_compensatory_details', 'pf_wages')) {
                $table->text('pf_wages')->nullable()->after('pf_admin_charges');
            }
            if (!Schema::hasColumn('vmt_employee_compensatory_details', 'total_deduction')) {
                $table->text('total_deduction')->nullable()->after('pf_wages');
            }
            if (!Schema::hasColumn('vmt_employee_compensatory_details', 'vda')) {
                $table->text('vda')->nullable()->after('employer_lwf');
            }
            if (!Schema::hasColumn('vmt_employee_compensatory_details', 'unifrom_allowance')) {
                $table->text('unifrom_allowance')->nullable()->after('washing_allowance');
            }
            if (!Schema::hasColumn('vmt_employee_compensatory_details', 'epf_employee')) {
                $table->text('epf_employee')->nullable()->after('employee_lwf');
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

            if (Schema::hasColumn('vmt_employee_compensatory_details', 'washing_allowance')) {
                $table->dropColumn('washing_allowance');
            }
            if (Schema::hasColumn('vmt_employee_compensatory_details', 'driver_salary')) {
                $table->dropColumn('driver_salary');
            }
            if (Schema::hasColumn('vmt_employee_compensatory_details', 'fuel_reimbursement')) {
                $table->dropColumn('fuel_reimbursement');
            }
            if (Schema::hasColumn('vmt_employee_compensatory_details', 'vpf_employee')) {
                $table->dropColumn('vpf_employee');
            }
            if (Schema::hasColumn('vmt_employee_compensatory_details', 'conveniance')) {
                $table->dropColumn('conveniance');
            }
            if (Schema::hasColumn('vmt_employee_compensatory_details', 'employer_lwf')) {
                $table->dropColumn('employer_lwf');
            }
            if (Schema::hasColumn('vmt_employee_compensatory_details', 'employee_lwf')) {
                $table->dropColumn('employee_lwf');
            }

            if (Schema::hasColumn('vmt_employee_compensatory_details', 'vehicle_reimbursement')) {
                $table->dropColumn('vehicle_reimbursement');
            }
            if (Schema::hasColumn('vmt_employee_compensatory_details', 'pf_wages')) {
                $table->dropColumn('pf_wages');
            }
            if (Schema::hasColumn('vmt_employee_compensatory_details', 'total_deduction')) {
                $table->dropColumn('total_deduction');
            }
            if (Schema::hasColumn('vmt_employee_compensatory_details', 'vda')) {
                $table->dropColumn('vda');
            }
            if (Schema::hasColumn('vmt_employee_compensatory_details', 'unifrom_allowance')) {
                $table->dropColumn('unifrom_allowance');
            }
            if (Schema::hasColumn('vmt_employee_compensatory_details', 'epf_employee')) {
                $table->dropColumn('epf_employee');
            }
        });
    }
};
