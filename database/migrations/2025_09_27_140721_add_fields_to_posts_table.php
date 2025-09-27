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
        Schema::table('posts', function (Blueprint $table) {
            $table->string('status')->after('description');
            $table->timestamp('published_at')->nullable()->after('allow_comments');
            $table->timestamp('banned_at')->nullable()->after('published_at');
            $table->timestamp('trashed_at')->nullable()->after('banned_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['status', 'published_at', 'banned_at', 'trashed_at']);
        });
    }
};
