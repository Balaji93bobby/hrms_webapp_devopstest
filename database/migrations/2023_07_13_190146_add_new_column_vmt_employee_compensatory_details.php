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
          Schema::table('vmt_employee_compensatory_details', function (Blueprint $table) {
            $table->text('epf_employee_contribution')->after('epf_employer_contribution');
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
        Schema::table('vmt_employee_compensatory_details', function (Blueprint $table) {

            $table->dropColumn('epf_employee_contribution');
        });
    }
};
