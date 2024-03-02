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
        Schema::create('vmt_pms_settings_v3', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('vmt_client_master');
            $table->text('annual_score_calc_method');
            $table->text('can_emp_proceed_next_pms')->default("0");
            $table->text('can_org_proceed_next_pms')->default("0");
            $table->text('show_overall_score_self_app_scrn')->default("0");
            $table->text('show_rating_card_review_page')->default("0");
            $table->text('show_overall_scr_review_page')->default("0");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vmt_pms_settings_v3');
    }
};
