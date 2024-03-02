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
             if (!Schema::hasColumn('vmt_employee_compensatory_details', 'medical_deduction')) {
                $table->text('medical_deduction')->nullable()->after('medical_allowance');
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
            Schema::table('vmt_employee_compensatory_details', function (Blueprint $table) {
                $table->dropColumn('medical_deduction');

            });
        });
    }
};
