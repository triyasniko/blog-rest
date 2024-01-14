<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jobapplications', function (Blueprint $table) {
            $table->bigIncrements('application_id'); // Menggunakan 'task_id' sebagai primary key
            $table->unsignedBigInteger('user_id');
            $table->string('job_title');
            $table->bigInteger('position_id');
            $table->string('company_name');
            $table->bigInteger('companysector_id');
            $table->string('application_date');
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobapplications');
    }
};
