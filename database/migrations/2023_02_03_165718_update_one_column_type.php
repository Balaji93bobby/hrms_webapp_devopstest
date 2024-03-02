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
        Schema::table('vmt_employees_leaves_accrued', function (Blueprint $table) {
            $table->text('accrued_leave_count')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vmt_employees_leaves_accrued', function (Blueprint $table) {
            $table->integer('accrued_leave_count')->change();
        });
    }
};
