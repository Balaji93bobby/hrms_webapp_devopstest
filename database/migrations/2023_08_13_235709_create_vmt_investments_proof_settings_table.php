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
        Schema::create('vmt_investments_proof_settings', function (Blueprint $table) {
            $table->id();
            $table->integer("client_id");
            $table->integer("do_emp_provide_inv_proof");
            $table->integer("is_compulsary_provide_comment");
            $table->integer("can_emp_switch_tax_regime");
            $table->integer("inv_schedule_date_1_enabled");
            $table->date("inv_schedule_date_1_value");
            $table->integer("inv_schedule_date_2_enabled");
            $table->date("inv_schedule_date_2_value");
            $table->integer("inv_schedule_date_3_enabled");
            $table->date("inv_schedule_date_3_value");
            $table->integer("can_notify_emp_inv_dec_release");
            $table->integer("can_sendemail_emp_inv_dec");
            $table->integer("notify_frequency");
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
        Schema::dropIfExists('vmt_investments_proof_settings');
    }
};
