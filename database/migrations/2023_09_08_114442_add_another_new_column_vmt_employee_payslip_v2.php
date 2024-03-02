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
            if (!Schema::hasColumn('vmt_employee_payslip_v2', 'lta')) {
                $table->text('lta')->nullable()->after('medical_allowance_arrear');
            }
            if (!Schema::hasColumn('vmt_employee_payslip_v2', 'earned_lta')) {
                $table->text('earned_lta')->nullable()->after('lta');
            }
            if (!Schema::hasColumn('vmt_employee_payslip_v2', 'lta_arrear')) {
                $table->text('lta_arrear')->nullable()->after('earned_lta');
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
            $table->dropColumn('lta');
            $table->dropColumn('earned_lta');
            $table->dropColumn('lta_arrear');
        });
    }
};
