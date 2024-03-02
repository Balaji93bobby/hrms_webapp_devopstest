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
        Schema::create('vmt_employee_family_details', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id");
            $table->text("name")->default("");
            $table->text("relationship")->default("");
            $table->date("dob")->nullable();
            $table->text("phone_number")->default("");

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
        Schema::dropIfExists('vmt_employee_family_details');
    }
};
