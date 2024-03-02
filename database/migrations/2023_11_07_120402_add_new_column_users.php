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
        Schema::table('users', function (Blueprint $table) {
            //
            if (!Schema::hasColumn('users', 'worker_type')) {
                $table->text('worker_type')->nullable()->after('onboard_type');
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
        Schema::table('users', function (Blueprint $table) {
            //
            if (Schema::hasColumn('users', 'worker_type')) {
                $table->dropColumn('worker_type');
            }
        });
    }
};
