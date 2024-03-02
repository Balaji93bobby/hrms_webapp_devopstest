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
        Schema::table('vmt_temp_employee_proof_documents', function (Blueprint $table) {
            //
            if (!Schema::hasColumn('vmt_employee_details', 'doc_type')) {
                $table->text('doc_type')->nullable()->after('status');
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
        Schema::table('vmt_temp_employee_proof_documents', function (Blueprint $table) {
            //
            if (Schema::hasColumn('vmt_temp_employee_proof_documents', 'doc_type')) {
                $table->dropColumn('doc_type');
            }
        });
    }
};
