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
        Schema::table('users', function (Blueprint $table) {
          $table->after('password',function($table){
             $table->boolean('has_two_factor_enabled')->default(false);
             $table->text('two_factor_secret')->nullable();
             $table->text('two_factor_recovery_codes')->nullable();
             $table->boolean('recovery_codes_downloaded')->default(false);
          });
          
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'has_two_factor_enabled',
                'two_factor_secret', 
                'two_factor_recovery_codes',
                'recovery_codes_downloaded'
                ]);
        });
    }
};
