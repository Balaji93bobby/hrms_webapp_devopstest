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
        //
        Schema::create('vmt_employees_leaves_accrued', function (Blueprint $table) {
            $table->id();
            $table->text('user_id');
            $table->date('date');
            $table->text('leave_type_id');
            $table->integer('accrued_leave_count');
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
        //
        Schema::dropIfExists('vmt_employees_leaves_accrued');
    }
};
