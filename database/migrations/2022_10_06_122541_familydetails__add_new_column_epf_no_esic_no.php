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
            $table->text("epf_number")->default("0")->after('uan_number');
            $table->text("esic_number")->default("0")->after('epf_number');
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
            $table->dropColumn("epf_number");
            $table->dropColumn("esic_number");
        });
    }
};
