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
        Schema::table('vmt_employee_compensatory_details',function (Blueprint $table) {
            if (Schema::hasColumn('vmt_employee_compensatory_details', 'epf_employee')) {
                $table->renameColumn('epf_employee','epf_employee_contribution');
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
            $table->renameColumn('epf_employee_contribution', 'epf_employee');
        });
    }
};
