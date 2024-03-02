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
        //
        Schema::table('vmt_employee_payslip_v2', function (Blueprint $table) {

            if (!Schema::hasColumn('vmt_employee_payslip_v2', 'daily_allowance')) {
                $table->text('daily_allowance')->after('spl_alw');
            }
            if (!Schema::hasColumn('vmt_employee_payslip_v2', 'ovetime_hours')) {
                $table->text('ovetime_hours')->after('overtime');
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
        //

        Schema::table('vmt_employee_payslip_v2', function (Blueprint $table) {
            //
            $table->dropColumn('daily_allowance');
            $table->dropColumn('ovetime_hours');
        });
    }
};
