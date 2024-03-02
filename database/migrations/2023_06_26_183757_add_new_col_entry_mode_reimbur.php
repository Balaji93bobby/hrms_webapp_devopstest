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
            $table->text('entry_mode')->after('reimbursement_type_id');
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
            $table->dropColumn('entry_mode');
        });
    }
};
