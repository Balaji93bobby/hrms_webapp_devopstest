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
        Schema::table('vmt_employee_compensatory_details', function (Blueprint $table) {
            //
            if (!Schema::hasColumn('vmt_employee_compensatory_details', 'vehicle_reimbursement')) {
                $table->text('vehicle_reimbursement')->nullable()->after('other_allowance');
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
        Schema::table('vmt_employee_compensatory_details', function (Blueprint $table) {
            //
            $table->dropColumn('vehicle_reimbursement');
        });
    }
};
