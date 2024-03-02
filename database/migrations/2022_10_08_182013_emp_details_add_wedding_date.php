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
        Schema::table('vmt_employee_family_details', function (Blueprint $table) {
            $table->date('wedding_date')->default(null)->after('dob');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vmt_employee_family_details', function (Blueprint $table) {
            $table->dropColumn('wedding_date');
        });
    }
};
