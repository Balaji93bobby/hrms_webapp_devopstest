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
            $table->text('mother_dob')->nullable();
            $table->text('father_dob')->nullable();
            $table->text('father_gender')->nullable();
            $table->text('mother_gender')->nullable();
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
            $table->dropColumn('mother_dob');
            $table->dropColumn('father_dob');
            $table->dropColumn('father_gender');
            $table->dropColumn('mother_gender');
        });
    }
};
