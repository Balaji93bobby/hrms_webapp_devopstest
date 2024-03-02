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
            if (!Schema::hasColumn('vmt_pms_kpiform_reviews_v3', 'assignee_acceptreject_date')) {
                $table->date('assignee_acceptreject_date')->nullable()->after('assignee_kpi_comments');
            }
            if (!Schema::hasColumn('vmt_pms_kpiform_reviews_v3', 'assignee_acceptreject_comments')) {
                $table->text('assignee_acceptreject_comments')->nullable()->after('assignee_acceptreject_date');
            }
            if (!Schema::hasColumn('vmt_pms_kpiform_reviews_v3', 'assignee_reviewed_date')) {
                $table->date('assignee_reviewed_date')->nullable()->after('assignee_acceptreject_comments');
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
            if (Schema::hasColumn('vmt_pms_kpiform_reviews_v3', 'assignee_acceptreject_date')) {
                $table->dropColumn('assignee_acceptreject_date');
            }
            if (Schema::hasColumn('vmt_pms_kpiform_reviews_v3', 'assignee_acceptreject_date')) {
                $table->dropColumn('assignee_acceptreject_comments');
            }
            if (Schema::hasColumn('vmt_pms_kpiform_reviews_v3', 'assignee_acceptreject_date')) {
                $table->dropColumn('assignee_reviewed_date');
            }
        });
    }
};
