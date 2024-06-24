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
        Schema::create('daily_entries', function (Blueprint $table) {
            $table->id('daily_entry_id');
            $table->integer('user_id');
            $table->date('entry_date');
            $table->integer('batch_id');
            $table->integer('tcid_id');
            $table->integer('job_role_id');
            $table->integer('sector_id');
            $table->longText('images')->nullable();
            $table->enum('status',['Y','N'])->default('Y');
            $table->softDeletes('deleted_at', precision: 0);
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
        Schema::dropIfExists('daily_entries');
    }
};
