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
        Schema::create('abs_active_payslip', function (Blueprint $table) {
            $table->id();
            $table->text('payslip_name');
            $table->text('payslip_pdf');
            $table->text('payslip_mail');
            $table->text('payslip_view');
            $table->text('is_active');
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
        Schema::dropIfExists('abs_active_payslip');
    }
};
