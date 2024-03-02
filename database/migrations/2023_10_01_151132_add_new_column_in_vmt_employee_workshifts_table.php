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
        Schema::table('vmt_employee_workshifts', function (Blueprint $table) {
            $table->integer('can_calculate_ot')->after('flexi_shift_status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vmt_employee_workshifts', function (Blueprint $table) {
            $table->dropColumn('can_calculate_ot');
        });
    }
};
