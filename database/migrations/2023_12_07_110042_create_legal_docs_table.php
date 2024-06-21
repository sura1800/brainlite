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
        Schema::create('legal_docs', function (Blueprint $table) {
            $table->id()->from(1001);
            $table->string('uqid')->unique()->nullable();
            $table->string('slug');
            $table->string('aadhaar_no');
            $table->string('noc_no');
            $table->string('location')->nullable();
            $table->string('doc_file')->unique();
            $table->string('doc_file_enc')->unique()->nullable()->comment("encryped_file_name");
            $table->text('admin_comment')->nullable();
            $table->text('customer_comment')->nullable();
            $table->string('status')->default(1);
            $table->timestamps();
            // $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('legal_docs');
    }
};
