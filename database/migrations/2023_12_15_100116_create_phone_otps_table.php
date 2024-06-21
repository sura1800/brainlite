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
        Schema::create('phone_otps', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
            $table->string('otp')->nullable();
            $table->timestamp('otp_expire_at')->nullable();
            $table->tinyInteger('verified')->default(0);
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
        Schema::dropIfExists('phone_otps');
    }
};
