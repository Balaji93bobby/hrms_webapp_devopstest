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
        Schema::create('vmt_pms_kpiform_assigned', function (Blueprint $table) {
            $table->id();
            $table->text('vmt_pms_kpiform_id');
            $table->text('assignee_id');//csv values
            $table->text('reviewer_id');//csv values
            $table->text('assigner_id');
            $table->text('calendar_type');
            $table->text('year');
            $table->text('frequency');
            $table->text('assignment_period');
            $table->text('department_id');

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
        Schema::dropIfExists('vmt_pms_kpiform_assigned');
    }
};
