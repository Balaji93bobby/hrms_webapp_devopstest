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
        Schema::table('vmt_documents', function (Blueprint $table) {
            //
            if (!Schema::hasColumn('vmt_documents', 'doc_image')) {
                $table->text('doc_image')->nullable()->after('document_name');
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
        Schema::table('vmt_documents', function (Blueprint $table) {
            //
            if (Schema::hasColumn('vmt_documents', 'doc_image')) {
                $table->dropColumn('doc_image');
            }
        });
    }
};
