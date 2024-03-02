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
        Schema::create('vmt_pms_kpiform_reviews_v3', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vmt_kpiform_assigned_v3_id');
            $table->text('assignee_id');
            $table->text('is_assignee_accepted');
            $table->text('is_assignee_submitted');
            $table->text('reviewer_details');
            $table->text('assignee_rejection_comments');
            $table->text('assignee_kpi_review');
            $table->text('assignee_kpi_percentage');
            $table->text('assignee_kpi_comments');
            $table->text('is_reviewer_accepted');
            $table->text('is_reviewer_submitted');
            $table->text('reviewer_kpi_review');
            $table->text('reviewer_kpi_percentage');
            $table->text('reviewer_kpi_comments');
            $table->text('reviewer_appraisal_comments');
            $table->timestamps();

            $table->foreign('vmt_kpiform_assigned_v3_id')->references('id')->on('vmt_pms_kpiform_assigned_v3');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vmt_pms_kpiform_reviews_v3');
    }
};
