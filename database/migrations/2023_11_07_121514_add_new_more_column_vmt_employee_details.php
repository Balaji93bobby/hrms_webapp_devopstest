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
        Schema::table('vmt_employee_details', function (Blueprint $table) {
            //
            if (!Schema::hasColumn('vmt_employee_details', 'salary_payment_mode')) {
                $table->text('salary_payment_mode')->nullable()->after('bank_account_number');
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
        Schema::table('vmt_employee_details', function (Blueprint $table) {
            //
            if (Schema::hasColumn('vmt_employee_details', 'salary_payment_mode')) {
                $table->dropColumn('salary_payment_mode');
            }
        });
    }
};
