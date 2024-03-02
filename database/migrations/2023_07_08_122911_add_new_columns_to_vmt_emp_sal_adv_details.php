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
            $table->text('sal_adv_status')->after('sal_adv_crd_sts');
            $table->text('reviewer_cmds')->nullable()->after('sal_adv_status');
            $table->date('paid_date')->nullable()->after('reviewer_cmds');
            $table->text('UTR_number')->nullable()->after('paid_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        dropColumnIfExists("vmt_emp_sal_adv_details",'sal_adv_status');
        dropColumnIfExists("vmt_emp_sal_adv_details",'reviewer_cmds');
        dropColumnIfExists("vmt_emp_sal_adv_details",'paid_date');
        dropColumnIfExists("vmt_emp_sal_adv_details",'UTR_number');
    }
};
