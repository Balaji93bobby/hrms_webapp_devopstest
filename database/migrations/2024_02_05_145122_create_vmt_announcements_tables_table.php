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

        Schema::dropIfExists('vmt_announcement');

        Schema::create('vmt_announcements_table', function (Blueprint $table) {
            $table->id();
            $table->text('announcement_title');
            $table->text('announcement_msg');
            $table->text('attach_img');
            $table->date('schedule_date');
            $table->time('start_time');
            $table->time('end_time');
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
        Schema::dropIfExists('vmt_announcements_tables');
    }
};
