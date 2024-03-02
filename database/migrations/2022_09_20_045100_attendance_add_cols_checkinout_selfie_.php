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
            $table->text('selfie_checkin')->nullable();//store the image path here
            $table->text('selfie_checkout')->nullable();//store the image path here
            $table->text('checkin_comments')->nullable();
            $table->text('checkout_comments')->nullable();
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
            $table->dropColumn('selfie_checkin');
            $table->dropColumn('selfie_checkout');
            $table->dropColumn('checkin_comments');
            $table->dropColumn('checkout_comments');
        });
    }
};
