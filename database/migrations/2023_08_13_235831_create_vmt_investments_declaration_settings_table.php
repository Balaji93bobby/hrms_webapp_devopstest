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
        Schema::create('vmt_investments_declaration_settings', function (Blueprint $table) {
            $table->id();
            $table->integer("client_id");
            $table->integer("consider_default_rent_hra");
            $table->integer("allow_emp_review_fin_info");
            $table->integer("salary_payment_mode");
            $table->integer("bank_information");
            $table->integer("pf_esi_info");
            $table->integer("pan_info");
            $table->integer("aadhar_info");
            $table->date("deadline_date_for_OTR");
            $table->date("newjoine_inv_inout_deadline");
            $table->date("inv_dec_cutoff_date");
            $table->date("newjoinee_dec_deadline");
            $table->date("modify_fy_cutoff_date");
            $table->date("inv_decl_approval_date");
            $table->integer("is_inv_decl_approval_needed");
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
        Schema::dropIfExists('vmt_investments_declaration_settings');
    }
};
