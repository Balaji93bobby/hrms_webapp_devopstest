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
        Schema::table('vmt_app_modules', function (Blueprint $table) {
            //
            if (Schema::hasColumn('vmt_app_modules', 'internal_name')) {
                $table->renameColumn('internal_name','title');
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
        Schema::table('vmt_app_modules', function (Blueprint $table) {
            //

            if (Schema::hasColumn('vmt_app_modules', 'title')) {
                $table->dropColumn('title');
            }

        });
    }
};
