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
        Schema::table('vmt_emp_sal_adv_details', function (Blueprint $table) {
            $table->renameColumn('approver_flow','emp_approver_flow');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vmt_emp_sal_adv_details', function (Blueprint $table) {
            $table->renameColumn('emp_approver_flow', 'approver_flow');
        });
    }
};
