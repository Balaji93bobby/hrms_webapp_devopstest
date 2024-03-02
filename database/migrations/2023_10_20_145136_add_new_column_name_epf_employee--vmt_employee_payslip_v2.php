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
            if (!Schema::hasColumn('vmt_employee_payslip_v2', 'payment_mode')) {
                $table->text('payment_mode')->after('vpf');
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

            if (Schema::hasColumn('vmt_employee_payslip_v2', 'payment_mode')) {

                $table->dropColumn('payment_mode');
            }

        });
    }
};
