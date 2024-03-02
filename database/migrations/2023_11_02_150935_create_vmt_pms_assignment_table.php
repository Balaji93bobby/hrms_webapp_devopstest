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
        Schema::create('vmt_pms_assignment_v3', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pms_assignment_settings_id');
            $table->text('assignment_period');
            $table->date('assignment_start_date');
            $table->date('assignment_end_date');
            $table->text('completion_status');
            $table->integer('active')->default(0);
            $table->text('selected_headers');
            $table->text('who_can_set_goal');
            $table->text('final_kpi_score_based_on');
            $table->text('should_mgr_appr_rej_goals')->default(0);
            $table->text('should_emp_acp_rej_goals')->default(0);
            $table->text('duedate_goal_settigns');
            $table->text('duedate_emp_mgr_approval');
            $table->text('duedate_self_review');
            $table->text('duedate_mgr_review');
            $table->text('duedate_hr_review');
            $table->text('reviewers_flow');
            $table->timestamps();

            $table->foreign('pms_assignment_settings_id')->references('id')->on('vmt_pms_assignment_settings_v3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vmt_pms_assignment_v3');
    }
};
