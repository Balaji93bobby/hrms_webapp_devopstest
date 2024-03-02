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
            $table->dropColumn('washing_allowance');
            $table->dropColumn('driver_salary');
            $table->dropColumn('fuel_reimbursement');
            $table->dropColumn('vpf_employee');
            $table->dropColumn('conveniance');
        });
    }
};
