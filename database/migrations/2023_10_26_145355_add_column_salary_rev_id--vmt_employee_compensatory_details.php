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

            if (!Schema::hasColumn('vmt_employee_compensatory_details', 'sal_revision_id')) {
                $table->integer('sal_revision_id')->after('vehicle_reimbursement');
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
            if (Schema::hasColumn('vmt_employee_compensatory_details', 'sal_revision_id')) {
                $table->dropColumn('sal_revision_id');
            }

        });
     }
};
