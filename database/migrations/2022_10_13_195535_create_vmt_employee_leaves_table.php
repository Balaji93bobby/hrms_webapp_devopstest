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
        Schema::create('vmt_employee_leaves', function (Blueprint $table) {
            $table->id();
            $table->integer('leave_type_id')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->text('leave_reason')->nullable();
            $table->integer('reviewer_user_id')->nullable();
            $table->json('notifications_users_id')->nullable();
            $table->text('reviewer_comments')->nullable();
            $table->text('status')->nullable();

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
        Schema::dropIfExists('vmt_employee_leaves');
    }
};
