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
        Schema::table('vmt_payroll_tally', function (Blueprint $table) {

            $table->string('generated_json_payrolljournal')->nullable()->after('vmt_payroll_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vmt_payroll_tally', function (Blueprint $table) {

            $table->dropColumn('generated_json_payrolljournal');

        });
    }
};
