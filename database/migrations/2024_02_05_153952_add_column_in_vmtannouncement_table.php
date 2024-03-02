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
        Schema::table('vmt_announcements_table', function (Blueprint $table) {
            $table->text('author_id')->after('id');
            $table->text('client_id')->after('author_id');
            $table->renameColumn('schedule_date', 'schedule_startdate');
            $table->date('schedule_enddate')->after('start_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vmt_announcements_table', function (Blueprint $table) {
            $table->dropColumn('author_id');
            $table->dropColumn('client_id');
        });
    }
};
