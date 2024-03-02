<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void max
     */
    public function up()
    {
        Schema::create('vmt_pms_kpiform_assigned_v3', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vmt_pms_kpiform_v3_id');
            $table->text('assignee_id');
            $table->text('reviewer_id');
            $table->text('assigner_id');
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
        Schema::dropIfExists('vmt_pms_kpiform_assigned_v3');
    }
};
