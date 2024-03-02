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
        Schema::table('vmt_employee_payslip_v2', function (Blueprint $table) {
            //

            if (!Schema::hasColumn('vmt_employee_payslip_v2', 'medical_allowance')) {
                $table->text('medical_allowance')->nullable()->after('child_edu_allowance_arrear');
            }
            if (!Schema::hasColumn('vmt_employee_payslip_v2', 'medical_allowance_earned')) {
                $table->text('medical_allowance_earned')->nullable()->after('medical_allowance');
            }
            if (!Schema::hasColumn('vmt_employee_payslip_v2', 'medical_allowance_arrear')) {
                $table->text('medical_allowance_arrear')->nullable()->after('medical_allowance_earned');
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
        Schema::table('vmt_employee_payslip_v2', function (Blueprint $table) {
            //
            $table->dropColumn('medical_allowance');
            $table->dropColumn('medical_allowance_earned');
            $table->dropColumn('medical_allowance_arrear');
        });
    }
};
