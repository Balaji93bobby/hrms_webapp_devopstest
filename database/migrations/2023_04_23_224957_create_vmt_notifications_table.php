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
        Schema::create('vmt_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->text('notification_title');
            $table->text('notification_body');
            $table->text('redirect_to_module'); //To which module we need to send when notif clicked
            $table->foreignId('recipient_user_id')->constrained('users');
            $table->integer('is_read')->default(0);

            //id, user_id, notification_title, notification_body, recipient_user_id, is_read
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
        Schema::dropIfExists('vmt_notifications');
    }
};
