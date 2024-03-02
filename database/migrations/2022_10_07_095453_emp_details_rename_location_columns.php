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
            $table->renameColumn("ptax_location", "ptax_location_state_id");
            $table->renameColumn("lwf_location","lwf_location_state_id");
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
            $table->renameColumn("ptax_location_state_id","ptax_location");
            $table->renameColumn("lwf_location_state_id","lwf_location");
        });
    }
};
