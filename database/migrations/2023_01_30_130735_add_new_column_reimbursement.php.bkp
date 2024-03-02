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
        Schema::table('vmt_employee_reimbursements', function (Blueprint $table) {
            $table->text('from')->nullable();
            $table->text('to')->nullable();
            $table->text('vehicle_type')->nullable();
            $table->text('distance_travelled')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vmt_employee_reimbursements', function (Blueprint $table) {
            $table->dropColumn('from');
            $table->dropColumn('to');
            $table->dropColumn('vehicle_type');
            $table->dropColumn('distance_travelled');
        });
    }
};
