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
        Schema::table('vmt_pms_kpiform_reviews_v3', function (Blueprint $table) {
            //
            if (!Schema::hasColumn('vmt_pms_kpiform_reviews_v3', 'reviewer_score')) {
                $table->text('reviewer_score')->nullable()->after('reviewer_appraisal_comments');
            }

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vmt_pms_kpiform_reviews_v3', function (Blueprint $table) {
            //
            if (Schema::hasColumn('vmt_pms_kpiform_reviews_v3', 'reviewer_score')) {
                $table->dropColumn('reviewer_score');
            }

        });
    }
};
