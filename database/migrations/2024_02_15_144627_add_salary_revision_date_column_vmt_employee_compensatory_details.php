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
        Schema::table('vmt_employee_compensatory_details', function (Blueprint $table) {
            //
            if (!Schema::hasColumn('vmt_employee_compensatory_details', 'revision_date')) {
                $table->date('revision_date')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('vmt_employee_compensatory_details', 'salary_revision_date')) {
                $table->date('effective_date')->nullable()->after('revision_date');
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
        Schema::table('vmt_employee_compensatory_details', function (Blueprint $table) {
            //
            if (Schema::hasColumn('vmt_employee_compensatory_details', 'revision_date')) {
                $table->dropColumn('revision_date');
            }
            if (Schema::hasColumn('vmt_employee_compensatory_details', 'effective_date')) {
                $table->dropColumn('effective_date');
            }
        });
    }
};
