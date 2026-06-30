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
        Schema::create('scraping_logs', function (Blueprint $table) {
           $table->id();
           $table->foreignId('scraping_source_id')->constrained('scraping_sources')->cascadeOnDelete();
           $table->enum('level', ['info','success', 'warning', 'error'])->default('info');
           $table->text('message');
           $table->timestamps();
 
           $table->index(['scraping_source_id', 'created_at']);
           $table->index('level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scraping_logs');
    }
};
