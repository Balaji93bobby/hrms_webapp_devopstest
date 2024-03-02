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
            if (!Schema::hasColumn('vmt_employee_payslip_v2', 'employee_lwf')) {
                $table->integer('employee_lwf')->nullable()->after('fbp');
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
                $table->dropColumn('employee_lwf');
            }
        });
    }
};
