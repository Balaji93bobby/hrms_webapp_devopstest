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
        Schema::create('vmt_employee_absent_regularizations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users');

            $table->date("attendance_date");
            $table->string("regularization_type")->default("Absent Regularization");
            $table->time("checkin_time");
            $table->time("checkout_time");
            $table->string("reason");
            $table->string("custom_reason")->nullable();

            $table->integer("reviewer_id")->nullable();
            $table->string("reviewer_comments")->nullable();
            $table->date("reviewer_reviewed_date")->nullable();

            $table->string("status")->default("Pending");

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
        Schema::dropIfExists('vmt_employee_absent_regularizations');
    }
};
