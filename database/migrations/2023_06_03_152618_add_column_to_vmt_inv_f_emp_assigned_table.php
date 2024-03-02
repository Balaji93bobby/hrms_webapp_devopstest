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
        Schema::table('vmt_inv_f_emp_assigned', function (Blueprint $table) {
            $table->text('regime')->after('year')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vmt_inv_f_emp_assigned', function (Blueprint $table) {
            dropColumnIfExists('vmt_inv_f_emp_assigned',"regime");
        });
    }
};
