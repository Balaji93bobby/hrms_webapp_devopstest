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
        Schema::table('vmt_labour_welfare_fund_settings', function (Blueprint $table) {
            //
            if (!Schema::hasColumn('vmt_labour_welfare_fund_settings', 'lwf_number')) {
                $table->text('lwf_number');
            }
            if (!Schema::hasColumn('vmt_labour_welfare_fund_settings', 'district')) {
                $table->text('district')->nullable()->after('lwf_number');
            }
            if (!Schema::hasColumn('vmt_labour_welfare_fund_settings', 'location')) {
                $table->text('location')->nullable()->after('district');
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
        Schema::table('vmt_labour_welfare_fund_settings', function (Blueprint $table) {
            //
            if (Schema::hasColumn('vmt_labour_welfare_fund_settings', 'lwf_number')) {
                $table->dropColumn('lwf_number');
            }
            if (Schema::hasColumn('vmt_labour_welfare_fund_settings', 'district')) {
                $table->dropColumn('district');
            }
            if (Schema::hasColumn('vmt_labour_welfare_fund_settings', 'location')) {
                $table->dropColumn('location');
            }
        });
    }
};
