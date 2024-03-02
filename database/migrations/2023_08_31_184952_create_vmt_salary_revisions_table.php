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
        Schema::create('vmt_salary_revisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('vmt_client_master');
            $table->foreignId('user_id')->constrained('users');
            $table->text('frequency');
            $table->text('increment_on');
            $table->text('percentage');
            $table->text('amount');
            $table->date('effective_date');
            $table->text('reason')->nullable();
            $table->text('process_type');
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
        Schema::dropIfExists('vmt_salary_revisions');
    }
};
