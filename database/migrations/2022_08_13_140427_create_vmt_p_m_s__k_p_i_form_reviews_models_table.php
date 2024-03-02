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
        Schema::create('vmt_pms_kpiform_reviews', function (Blueprint $table) {
            $table->id();
            $table->text('vmt_pms_kpiform_assigned_id');

            $table->text('assignee_kpi_review');
            $table->text('assignee_kpi_percentage');
            $table->text('assignee_kpi_comments');

            $table->text('reviewer_kpi_review');
            $table->text('reviewer_kpi_percentage');
            $table->text('reviewer_kpi_comments');
            $table->text('reviewer_appraisal_comments');

            $table->text('assigner_kpi_review');
            $table->text('assigner_kpi_percentage');
            $table->text('assigner_kpi_comments');

            $table->text('assignee_kpi_status');
            $table->text('is_assignee_submitted');
            $table->text('is_assignee_accepted');

            $table->text('reviewer_kpi_status');
            $table->text('is_reviewer_submitted');
            $table->text('is_reviewer_accepted');

            $table->text('assignee_rejection_comments');
            $table->text('reviewer_rejection_comments');

            $table->text('overall_score');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vmt_pms_kpiform_reviews');
    }
};
