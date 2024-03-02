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

        Schema::dropIfExists('vmt_pms_settings_v3');

        Schema::table('vmt_pms_assignment_settings_v3', function (Blueprint $table) {
            $table->text('can_assign_upcoming_goals')->after('pms_rating_card')->nullable();
            $table->text('annual_score_calc_method')->after('can_assign_upcoming_goals')->nullable();
            $table->text('can_emp_proceed_next_pms')->after('annual_score_calc_method')->nullable();
            $table->text('can_org_proceed_next_pms')->after('can_emp_proceed_next_pms')->nullable();
            $table->text('show_overall_score_self_app_scrn')->after('can_org_proceed_next_pms')->nullable();
            $table->text('show_rating_card_review_page')->after('show_overall_score_self_app_scrn')->nullable();
            $table->text('show_overall_scr_review_page')->after('show_rating_card_review_page')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vmt_pms_assignment_settings_v3', function (Blueprint $table) {
            $table->dropColumn('can_assign_upcoming_goals');
            $table->dropColumn('annual_score_calc_method');
            $table->dropColumn('can_emp_proceed_next_pms');
            $table->dropColumn('can_org_proceed_next_pms');
            $table->dropColumn('show_overall_score_self_app_scrn');
            $table->dropColumn('show_rating_card_review_page');
            $table->dropColumn('show_overall_scr_review_page');
        });
    }
};
