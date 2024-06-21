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
        Schema::create('ledger_doc_legal_doc', function (Blueprint $table) {
            $table->id()->from(1001);
            $table->foreignId('legal_doc_id')->constrained('legal_docs')->cascadeOnUpdate();
            $table->foreignId('ledger_doc_id')->constrained('ledger_docs')->cascadeOnUpdate();
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
        Schema::dropIfExists('ledger_doc_legal_doc');
    }
};
