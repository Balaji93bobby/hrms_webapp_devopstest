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
        Schema::table('vmt_payroll_components', function (Blueprint $table) {
            //
            if (!Schema::hasColumn('vmt_payroll_components', 'comp_order')) {
                $table->text('comp_order')->nullable()->after('comp_identifier');
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
        Schema::table('vmt_payroll_components', function (Blueprint $table) {
            //
            if (Schema::hasColumn('vmt_payroll_components', 'comp_order')) {
                $table->dropColumn('comp_order');
            }
        });
    }
};
