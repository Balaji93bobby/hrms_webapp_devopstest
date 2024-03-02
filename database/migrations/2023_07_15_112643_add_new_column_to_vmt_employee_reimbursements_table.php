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
            if (!Schema::hasColumn('vmt_employee_reimbursements', 'from')) {
                $table->text('from');
            }
            if (!Schema::hasColumn('vmt_employee_reimbursements', 'to')) {
                $table->text('to');
            }
            if (!Schema::hasColumn('vmt_employee_reimbursements', 'vehicle_type_id')) {
                $table->text('vehicle_type_id');
            }
            if (!Schema::hasColumn('vmt_employee_reimbursements', 'distance_travelled')) {
                $table->text('distance_travelled');
            }
            if (!Schema::hasColumn('vmt_employee_reimbursements', 'total_expenses')) {
                $table->text('total_expenses');
            }
            if (!Schema::hasColumn('vmt_employee_reimbursements', 'entry_mode')) {
                $table->text('entry_mode');
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
        Schema::table('vmt_employee_reimbursements', function (Blueprint $table) {
            //
        });
    }
};
