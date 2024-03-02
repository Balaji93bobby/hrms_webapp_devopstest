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
        Schema::table('vmt_paygroup', function (Blueprint $table) {
            //
            if (!Schema::hasColumn('vmt_paygroup', 'creator_user_id')) {
                $table->integer('creator_user_id')->nullable()->after('fbp');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vmt_paygroup', function (Blueprint $table) {
            //
            if (Schema::hasColumn('vmt_paygroup', 'creator_user_id')) {
                $table->dropColumn('creator_user_id');
            }

        });
    }
};
