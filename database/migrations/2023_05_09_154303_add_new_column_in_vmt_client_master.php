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
        Schema::table('vmt_client_master', function (Blueprint $table) {
            $table->integer('abs_client_code')->after('id');
            $table->text('client_fullname')->after('abs_client_code');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vmt_client_master', function (Blueprint $table) {
            $table->dropColumn('abs_client_code');
            $table->dropColumn('client_fullname');
        });
    }
};
