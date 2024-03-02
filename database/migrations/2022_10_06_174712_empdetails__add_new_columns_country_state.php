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
        Schema::table('vmt_employee_details', function (Blueprint $table) {
            $table->text("current_country")->default("")->after('current_address_line_2');
            $table->text("current_state")->default("")->after('current_country');
            $table->text("permanent_country")->default("")->after('permanent_address_line_2');
            $table->text("permanent_state")->default("")->after('permanent_country');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vmt_employee_details', function (Blueprint $table) {
            $table->dropColumn("current_country");
            $table->dropColumn("current_state");
            $table->dropColumn("permanent_country");
            $table->dropColumn("permanent_state");
        });
    }
};
