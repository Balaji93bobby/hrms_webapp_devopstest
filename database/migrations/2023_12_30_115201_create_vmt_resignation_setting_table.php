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
        Schema::create('vmt_resignation_setting', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->integer('emp_can_apply_resignation')->default(0);
            $table->integer('manager_can_submit_resignation_for_emp')->default(0);
            $table->integer('hr_can_submit_resignation_for_emp')->default(0);
            $table->integer('emp_can_edit_last_working_day')->default(0);
            $table->integer('resignation_auto_approve')->default(0);
            $table->text('resignation_approver_flow');
            $table->text('email_reminder_for_resignation')->default(0);
            $table->timestamps();

            //foregin key
            $table->foreign('client_id')->references('id')->on('vmt_client_master');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vmt_resignation_setting');
    }
};
