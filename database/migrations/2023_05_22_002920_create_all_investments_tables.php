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

  Schema::create('vmt_inv_form', function (Blueprint $table) {
    $table->id();
    $table->text('form_name');
    $table->integer('active');
    $table->timestamps();
});


Schema::create('vmt_inv_section_group', function (Blueprint $table) {
    $table->id();
    $table->text('section_group');
    $table->timestamps();
});

Schema::create('vmt_inv_section', function (Blueprint $table) {
    $table->id();
    $table->foreignId('sectiongroup_id')->constrained('vmt_inv_section_group');
    $table->text('section');
    $table->text('particular');
    $table->text('reference');
    $table->integer('max_amount');
    $table->timestamps();
});

Schema::create('vmt_inv_formsection', function (Blueprint $table) {
    $table->id();
    $table->foreignId('form_id')->constrained('vmt_inv_form');
    $table->foreignId('section_id')->constrained('vmt_inv_section');
    $table->timestamps();
});


Schema::create('vmt_inv_f_emp_assigned', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained('users');
    $table->foreignId('form_id')->constrained('vmt_inv_form');
    $table->date('year');
    $table->timestamps();
});


Schema::create('vmt_inv_emp_formdata', function (Blueprint $table) {
    $table->id();
    $table->foreignId('f_emp_id')->constrained('vmt_inv_f_emp_assigned');
    $table->foreignId('fs_id')->constrained('vmt_inv_formsection');
    $table->integer('dec_amount');
    $table->json('json_popups_value')->nullable();
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
        Schema::dropIfExists('vmt_inv_emp_formdata');
        Schema::dropIfExists('vmt_inv_f_emp_assigned');
        Schema::dropIfExists('vmt_inv_formsection');
        Schema::dropIfExists('vmt_inv_section');
        Schema::dropIfExists('vmt_inv_section_group');
        Schema::dropIfExists('vmt_inv_form');
    }
};
