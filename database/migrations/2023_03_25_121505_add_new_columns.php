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
        Schema::table('vmt_employee_documents', function (Blueprint $table) {
            $table->text('reviewer_id')->nullable()->after('status');
            $table->text('reviewer_comments')->nullable()->after('reviewer_id');
            $table->dateTime('reviewed_date')->nullable()->after('reviewer_comments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vmt_employee_documents', function (Blueprint $table) {
            $table->dropColumn('reviewer_id');
            $table->dropColumn('reviewer_comments');
            $table->dropColumn('reviewed_date');
        });
    }
};
