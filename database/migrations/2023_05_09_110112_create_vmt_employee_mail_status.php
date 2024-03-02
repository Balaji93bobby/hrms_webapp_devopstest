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
        Schema::create('vmt_employee_mail_status', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');

            $table->integer('welcome_mail_status')->default(0);
            $table->integer('welcome_mail_sent_count');
            $table->dateTime('welcome_mail_status_datetime');

            $table->integer('onboard_docs_approval_mail_status')->default(0);
            $table->integer('onboard_docs_approval_mail_sent_count');
            $table->dateTime('onboard_docs_approval_mail_status_datetime');

            $table->integer('acc_activation_mail_status')->default(0);
            $table->integer('acc_activation_mail_sent_count');
            $table->dateTime('acc_activation_mail_status_datetime');

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
        Schema::dropIfExists('vmt_employee_mail_status');
    }
};
