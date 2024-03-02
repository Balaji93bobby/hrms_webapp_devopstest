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
        Schema::table('vmt_pms_kpiform_reviews', function (Blueprint $table) {
            $table->text('assignee_kpi_review')->nullable()->change();
            $table->text('assignee_kpi_percentage')->nullable()->change();
            $table->text('assignee_kpi_comments')->nullable()->change();
            $table->text('reviewer_kpi_review')->nullable()->change();
            $table->text('reviewer_kpi_percentage')->nullable()->change();
            $table->text('reviewer_kpi_comments')->nullable()->change();
            $table->text('reviewer_appraisal_comments')->nullable()->change();
            $table->text('assigner_kpi_review')->nullable()->change();
            $table->text('assigner_kpi_percentage')->nullable()->change();
            $table->text('assigner_kpi_comments')->nullable()->change();
            $table->text('assignee_kpi_status')->nullable()->change();
            $table->text('is_assignee_submitted')->nullable()->change();
            $table->text('is_assignee_accepted')->nullable()->change();
            $table->text('reviewer_kpi_status')->nullable()->change();
            $table->text('is_reviewer_submitted')->nullable()->change();
            $table->text('is_reviewer_accepted')->nullable()->change();
            $table->text('assignee_rejection_comments')->nullable()->change();
            $table->text('reviewer_rejection_comments')->nullable()->change();
            $table->text('overall_score')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vmt_pms_kpiform_reviews', function (Blueprint $table) {
            //
        });
    }
};
