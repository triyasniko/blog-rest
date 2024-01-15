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
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('article_id'); // Menggunakan 'task_id' sebagai primary key
            $table->unsignedBigInteger('user_id');
            $table->string('article_title');
            $table->string('article_description');
            $table->bigInteger('category_id');
            $table->bigInteger('tag_id');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
