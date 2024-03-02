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

            if (Schema::hasColumn('vmt_employee_reimbursements', 'vehicle_type')){ //check the column
                $table->renameColumn('vehicle_type', 'vehicle_type_id');
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
            $table->renameColumn('vehicle_type_id', 'vehicle_type');
        });
    }
};
