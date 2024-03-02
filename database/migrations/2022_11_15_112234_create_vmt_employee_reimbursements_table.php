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
        Schema::create('vmt_employee_reimbursements', function (Blueprint $table) {
            $table->id();
           $table->integer('user_id');
        $table-> integer('reimbursement_type_id');
            $table->dateTime('date');
            $table->text('user_documents');       
            $table->text('user_comments');
            $table->integer('reviewer_id');
            $table->dateTime('reviewed_date');
            $table->text('status');
            $table->text('reviewer_comments');
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
        Schema::dropIfExists('vmt_employee_reimbursements');
    }
};
