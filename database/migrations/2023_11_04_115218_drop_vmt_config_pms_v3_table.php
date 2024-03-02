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
        Schema::dropIfExists('vmt_config_pms_v3');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('vmt_config_pms_v3', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->text('client_id');
            $table->text('can_show_overallscorecard_in_selfappraisal_dashboard');
            $table->text('can_show_overallscorecard_in_reviewpage');
            $table->text('can_show_ratingcard_in_reviewpage');
            $table->text('calendar_type');
            $table->text('year');
            $table->text('frequency');
            $table->text('assignment_period');
            $table->text('overall_headers');
            $table->text('selected_headers');
            // $table->text('selected_head');
            $table->text('header_alias');
            $table->text('reviewers_flow');
            $table->timestamps();
        });
    }
};
