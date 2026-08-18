<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('two_factor_trusted_devices', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();
      $table->string('token_hash', 64)->unique();
      $table->string('device_name', 32)->nullable();
      $table->string('user_agent')->nullable();
      $table->string('ip', 45)->nullable();
      $table->timestamp('last_used_at')->nullable();
      $table->timestamp('expires_at');
      $table->timestamps();

      $table->index(['user_id', 'expires_at']);

    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('two_factor_trusted_devices');
  }
};
