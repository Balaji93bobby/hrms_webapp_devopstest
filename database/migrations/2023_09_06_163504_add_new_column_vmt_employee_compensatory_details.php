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
        Schema::table('vmt_employee_compensatory_details', function (Blueprint $table) {
            
        $table->text('edli_charges')->nullable();
        $table->text('pf_admin_charges')->nullable();
        $table->text('Income_tax')->nullable();
        $table->text('lwfee')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vmt_employee_compensatory_details', function (Blueprint $table) {

        $table->dropColumn('edli_charges');
        $table->dropColumn('pf_admin_charges');
        $table->dropColumn('Income_tax');
        $table->dropColumn('lwfee');

    });
}

};