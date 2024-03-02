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

        Schema::dropIfExists('vmt_inv_emp_fsp_popups');
        Schema::dropIfExists('vmt_inv_fsp_popups');
        Schema::dropIfExists('vmt_inv_popup_fields');
        Schema::dropIfExists('vmt_inv_popup_list');
        Schema::dropIfExists('vmt_emp_investments_dec_fields');
        Schema::dropIfExists('vmt_investment_declarations_fields');
        Schema::dropIfExists('vmt_emp_investments_dec_amt');
        Schema::dropIfExists('vmt_investment_form_secpat');
        Schema::dropIfExists('vmt_investment_section_particulars');
        Schema::dropIfExists('vmt_investment_particulars');
        Schema::dropIfExists('vmt_investment_sections');
        Schema::dropIfExists('vmt_investment_forms');


        Schema::dropIfExists('vmt_inv_emp_formdata');
        Schema::dropIfExists('vmt_inv_f_emp_assigned');
        Schema::dropIfExists('vmt_inv_formsection');
        Schema::dropIfExists('vmt_inv_section');
        Schema::dropIfExists('vmt_inv_section_group');
        Schema::dropIfExists('vmt_inv_form');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
