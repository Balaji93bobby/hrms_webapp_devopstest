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
        Schema::create('vmt_emp_paygroup_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vmt_emp_active_paygroup_id')->constrained('vmt_emp_active_paygroup');
            $table->foreignId('vmt_emp_paygroup_id')->constrained('vmt_emp_paygroup');
            $table->text("Value");
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
        Schema::dropIfExists('vmt_emp_paygroup_values');
    }
};
