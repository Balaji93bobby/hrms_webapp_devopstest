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
            $table->text('children')->nullable();
            $table->text('religion')->nullable();
            $table->text('nationality')->nullable();
            $table->text('passport_date')->nullable();
            $table->text('passport_number')->nullable();
            $table->text('experience_json')->nullable();
            $table->text('family_info_json')->nullable();
            $table->text('contact_json')->nullable();

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
        });
    }
};
