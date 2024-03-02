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
        Schema::table('vmt_employee_details', function (Blueprint $table) {
            $table->renameColumn("current_country", "current_country_id");
            $table->renameColumn("permanent_country","permanent_country_id");
            $table->renameColumn("current_state","current_state_id");
            $table->renameColumn("permanent_state","permanent_state_id");
            $table->renameColumn("blood_group","blood_group_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vmt_employee_details', function (Blueprint $table) {
            $table->renameColumn( "current_country_id", "current_country");
            $table->renameColumn("permanent_country_id","permanent_country");
            $table->renameColumn("current_state_id","current_state");
            $table->renameColumn("permanent_state_id","permanent_state");
            $table->renameColumn("blood_group_id","blood_group");

        });
    }
};
