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
        Schema::create('vmt_employee_attendance_regularizations', function (Blueprint $table) {
            $table->id();
            $table->date('attendance_date')->default(null);
            $table->date('arrival_time')->default(null);
            $table->timestamp('regularize_time')->default(null);
            $table->text('reason')->default(null);
            $table->text('custom_reason')->default(null);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vmt_employee_attendance_regularizations');
    }
};
