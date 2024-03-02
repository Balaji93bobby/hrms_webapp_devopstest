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

        Schema::table('vmt_emp_paygroup_values', function (Blueprint $table) {
            //
            if(schema::hasColumn('vmt_emp_paygroup_values','vmt_emp_paygroup_id')){

                $table->dropForeign(['vmt_emp_paygroup_id']);
                $table->dropColumn('vmt_emp_paygroup_id');
            }

        });
        Schema::table('vmt_emp_paygroup_values', function (Blueprint $table) {
            //
            if(!schema::hasColumn('vmt_emp_paygroup_values','vmt_emp_paygroup_id')){
                $table->foreignId('vmt_emp_paygroup_id')->nullable()->after('vmt_emp_active_paygroup_id')->constrained('vmt_payroll_components');
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
        Schema::table('vmt_emp_paygroup_values', function (Blueprint $table) {
            //

            if(schema::hasColumn('vmt_emp_paygroup_values','vmt_emp_paygroup_id')){
                $table->dropForeign(['vmt_emp_paygroup_id']);
                $table->dropColumn('vmt_emp_paygroup_id');
            }

        });
        Schema::table('vmt_emp_paygroup_values', function (Blueprint $table) {
            //

            if(!schema::hasColumn('vmt_emp_paygroup_values','vmt_emp_paygroup_id')){
                $table->foreignId('vmt_emp_paygroup_id')->constrained('vmt_emp_paygroup');
            }

        });
    }
};
