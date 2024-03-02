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

            if (Schema::hasColumn('vmt_employee_details', 'marital_status')){ //check the column
                $table->renameColumn('marital_status', 'marital_status_id');
            }
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
            $table->renameColumn('marital_status_id', 'marital_status');
        });
    }
};
