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
        Schema::create('scraped_posts', function (Blueprint $table) {
          $table->id();
          $table->foreignId('scraping_source_id')->constrained('scraping_sources')->cascadeOnDelete();
          $table->string('link_hash', 32)->unique();
          $table->string('link', 2048);
          $table->string('title')->nullable();
          $table->text('description')->nullable();
          $table->string('category')->nullable();
          $table->string('image_url')->nullable();
          $table->timestamp('last_scraped_at')->useCurrent();
          $table->timestamps();

          $table->index(['scraping_source_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scraped_posts');
    }
};
