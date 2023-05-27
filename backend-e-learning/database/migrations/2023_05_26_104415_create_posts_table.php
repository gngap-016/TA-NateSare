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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->text('slug')->unique();
            $table->text('title');
            $table->text('image')->nullable();
            $table->text('excerpt');
            $table->longText('body');
            $table->enum('status', ['free', 'paid']);
            $table->boolean('publish');
            $table->foreignId('author_id');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
