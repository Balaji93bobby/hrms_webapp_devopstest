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
        Schema::create('vmt_client_org_documents', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id');
            $table->integer('doc_id');
            $table->text('doc_url');
            $table->text('status');
            $table->integer('reviewer_id');
            $table->text('reviewer_comments');
            $table->date('reviewer_date');
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
        Schema::dropIfExists('vmt_client_org_documents');
    }
};
