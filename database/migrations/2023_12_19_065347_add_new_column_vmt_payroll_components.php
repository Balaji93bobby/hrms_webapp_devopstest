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
            if (!Schema::hasColumn('vmt_payroll_components', 'reimburst_status')) {
                $table->text('reimburst_status');
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
            if (Schema::hasColumn('vmt_payroll_components', 'reimburst_status')) {

                $table->dropColumn('reimburst_status');
            }
        });
    }
};
