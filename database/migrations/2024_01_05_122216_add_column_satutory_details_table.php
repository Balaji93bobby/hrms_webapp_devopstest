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
        Schema::table('vmt_employee_statutory_details', function (Blueprint $table) {

            if (!Schema::hasColumn('vmt_employee_statutory_details', 'epf_abry_effective_date')) {
                $table->date('epf_abry_effective_date')->nullable();
            }
            if (!Schema::hasColumn('vmt_employee_statutory_details', 'eps_pension_effective_date')) {
                $table->date('eps_pension_effective_date')->nullable();
            }
            if (!Schema::hasColumn('vmt_employee_statutory_details', 'PMRPY_is_eligible')) {
                $table->integer('PMRPY_is_eligible')->nullable();
            }
            if (!Schema::hasColumn('vmt_employee_statutory_details', 'PMRPY_is_effective_date')) {
                $table->date('PMRPY_is_effective_date')->nullable();
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
        Schema::table('vmt_employee_statutory_details', function (Blueprint $table) {

            if (Schema::hasColumn('vmt_employee_statutory_details', 'epf_abry_effective_date')) {
                $table->dropColumn('epf_abry_effective_date');
            }
            if (Schema::hasColumn('vmt_employee_statutory_details', 'eps_pension_effective_date')) {
                $table->dropColumn('eps_pension_effective_date');
            }
            if (Schema::hasColumn('vmt_employee_statutory_details', 'PMRPY_is_eligible')) {
                $table->dropColumn('PMRPY_is_eligible');
            }
            if (Schema::hasColumn('vmt_employee_statutory_details', 'PMRPY_is_effective_date')) {
                $table->dropColumn('PMRPY_is_effective_date');
            }

        });
    }
};
