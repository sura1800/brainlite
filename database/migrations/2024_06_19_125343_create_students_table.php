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
        Schema::create('students', function (Blueprint $table) {
            $table->id('student_id');
            $table->bigInteger('username');
            $table->string('student_name');
            $table->string('candidate_reg_id');
            $table->bigInteger('mobile_no');
            $table->string('tp_id');
            $table->string('project_type');
            $table->string('sector');
            $table->string('batch_id');
            $table->string('acadamic_year');
            $table->string('qp_code');
            $table->string('job_role');
            $table->string('training_location');
            $table->string('state');
            $table->bigInteger('aadhar_no')->nullable();
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
        Schema::dropIfExists('students');
    }
};
