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
        Schema::table('vmt_pay_frequency', function (Blueprint $table) {
            //
            if (!Schema::hasColumn('vmt_pay_frequency', 'status')) {
                $table->integer('status')->nullable()->after('name');
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
        Schema::table('vmt_pay_frequency', function (Blueprint $table) {
            //
            if (Schema::hasColumn('vmt_pay_frequency', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
