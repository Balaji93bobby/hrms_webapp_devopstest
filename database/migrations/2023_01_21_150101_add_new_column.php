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
        Schema::table('vmt_employee_statutory_details', function (Blueprint $table) {
            
                $table->text('epf_abry_eligible');
                $table->text('eps_pension_eligible');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vmt_employee_statutory_details', function (Blueprint $table) {
            $table->text('epf_abry_eligible');
            $table->text('eps_pension_eligible');
    
        });
    }
};
