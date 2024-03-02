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
            $table->text("current_address_line_1")->default("none")->after('bank_account_number');
            $table->text("current_address_line_2")->default("none")->after('current_address_line_1');
            $table->text("permanent_address_line_1")->default("none")->after('current_address_line_2');
            $table->text("permanent_address_line_2")->default("none")->after('permanent_address_line_1');
            $table->text("current_city")->default("none")->after('permanent_address_line_2');
            $table->text("permanent_city")->default("none")->after('current_city');
            $table->text("current_pincode")->default("0")->after('permanent_city');
            $table->text("permanent_pincode")->default("0")->after('current_pincode');
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
            $table->dropColumn("current_address_line_1");
            $table->dropColumn("current_address_line_2");
            $table->dropColumn("permanent_address_line_1");
            $table->dropColumn("permanent_address_line_2");
            $table->dropColumn("current_city");
            $table->dropColumn("permanent_city");
            $table->dropColumn("current_pincode");
            $table->dropColumn("permanent_pincode");
        });
    }
};
