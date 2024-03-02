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
        Schema::table('vmt_employee_payslip', function (Blueprint $table) {
            $table->text('travel_conveyance')->default(0);
            $table->text('other_earnings')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vmt_employee_payslip', function (Blueprint $table) {
            $table->dropColumn('travel_conveyance');
            $table->dropColumn('other_earnings');
        });
    }
};
