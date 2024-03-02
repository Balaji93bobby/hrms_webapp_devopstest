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
        Schema::table('vmt_employee_attendance', function (Blueprint $table) {

            if (!Schema::hasColumn('vmt_employee_attendance', 'checkin_full_address')) {
                $table->text('checkin_full_address')->nullable()->after('checkin_lat_long');
            }

            if (!Schema::hasColumn('vmt_employee_attendance', 'checkout_full_address')) {
                $table->text('checkout_full_address')->nullable()->after('checkout_lat_long');
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
        Schema::table('vmt_employee_attendance', function (Blueprint $table) {
            $table->dropColumn('checkin_full_address');
            $table->dropColumn('checkout_full_address');
        });
    }
};
