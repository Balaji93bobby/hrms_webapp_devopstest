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
        Schema::table('vmt_salary_adv_setting', function (Blueprint $table) {
            $table->text('can_borrowed_multiple')->after('approver_flow');
            $table->text('settings_name')->after('id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        dropColumnIfExists("vmt_salary_adv_setting",'can_borrowed_multiple');
        dropColumnIfExists("vmt_salary_adv_setting",'settings_name');

    }
};
