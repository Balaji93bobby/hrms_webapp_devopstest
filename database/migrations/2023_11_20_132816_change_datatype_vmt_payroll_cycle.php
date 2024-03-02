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
        Schema::table('vmt_payroll_cycle', function (Blueprint $table) {
            //

            if (Schema::hasColumn('vmt_payroll_cycle', 'payperiod_end_date')) {
                $table->date('payperiod_end_date')->change();
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
        Schema::table('vmt_payroll_cycle', function (Blueprint $table) {
            //
            if (Schema::hasColumn('vmt_payroll_cycle', 'payperiod_end_date')) {
                $table->text('payperiod_end_date')->nullable()->change();
            }
        });
    }
};
