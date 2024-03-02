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
            if (Schema::hasColumn('vmt_employee_payslip_v2', 'lwf')) {
                $table->renameColumn('lwf','employee_lwf');
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
            if (Schema::hasColumn('vmt_employee_payslip_v2', 'employee_lwf')) {
                $table->renameColumn('employee_lwf','lwf');
            }
        });
    }
};
