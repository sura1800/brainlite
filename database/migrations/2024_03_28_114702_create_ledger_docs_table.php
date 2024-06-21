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
        Schema::create('ledger_docs', function (Blueprint $table) {
            $table->id()->from(1001);
            $table->string('uqlid')->unique()->nullable()->comment("unique ledger docs number system generated");
            $table->string('slug');
            $table->string('aadhaar_no');
            $table->string('ledger_file')->unique();
            $table->text('admin_comment')->nullable();
            $table->text('customer_comment')->nullable();
            $table->string('status')->default(1);
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
        Schema::dropIfExists('ledger_docs');
    }
};
