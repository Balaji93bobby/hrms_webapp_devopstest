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
        Schema::table('vmt_salary_revisions', function (Blueprint $table) {
            //

            if (Schema::hasColumn('vmt_salary_revisions','process_type')) {
                $table->renameColumn('process_type','process_status');
            }
            if (!Schema::hasColumn('vmt_salary_revisions', 'revised_amount')) {
                $table->text('revised_amount')->after('reason')->nullable();
            }
            if (!Schema::hasColumn('vmt_salary_revisions', 'arrear_calculation_type')) {
                $table->integer('arrear_calculation_type')->after('revised_amount')->nullable();
            }
            if (!Schema::hasColumn('vmt_salary_revisions', 'status')) {
                $table->text('status')->after('arrear_calculation_type')->nullable();
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
        Schema::table('vmt_salary_revisions', function (Blueprint $table) {
            //
            if (Schema::hasColumn('vmt_salary_revisions', 'process_status')) {
                $table->renameColumn('process_status','process_type');
            }
            if (Schema::hasColumn('vmt_salary_revisions', 'revised_amount')) {
                $table->dropColumn('revised_amount');
            }
            if (Schema::hasColumn('vmt_salary_revisions', 'arrear_calculation_type')) {
                $table->dropColumn('arrear_calculation_type');
            }
            if (Schema::hasColumn('vmt_salary_revisions', 'status')){
                $table->dropColumn('status');
            }

        });
    }
};
