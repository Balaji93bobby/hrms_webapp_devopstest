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
        Schema::table('vmt_externalapps_tokens', function (Blueprint $table) {

            if (Schema::hasColumn('vmt_externalapps_tokens', 'last_token_generated_time')) {
                $table->renameColumn('last_token_generated_time','token_generated_time');
            }

            if (Schema::hasColumn('vmt_externalapps_tokens', 'last_token_accessed_time')) {
                $table->renameColumn('last_token_accessed_time','recent_token_accessed_time');
            }


            $table->dateTime('token_validity')->nullable()->after('access_token');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vmt_externalapps_tokens', function (Blueprint $table) {
            if (Schema::hasColumn('vmt_externalapps_tokens', 'token_generated_time')) {
                $table->renameColumn('token_generated_time','last_token_generated_time');
            }

            if (Schema::hasColumn('vmt_externalapps_tokens', 'recent_token_accessed_time')) {
                $table->renameColumn('recent_token_accessed_time','last_token_accessed_time');
            }

            $table->dropColumn('token_validity');
        });
    }
};
