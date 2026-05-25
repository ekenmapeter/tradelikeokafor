<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('forex_raw_articles', function (Blueprint $table) {
            $table->id();
            $table->string('source_name');
            $table->string('source_feed_url');
            $table->string('source_url')->unique();
            $table->string('raw_title');
            $table->longText('raw_content');
            $table->text('raw_excerpt')->nullable();
            $table->string('content_hash', 64)->unique();
            $table->timestamp('published_at')->nullable();
            $table->timestamp('fetched_at')->useCurrent();
            $table->enum('status', ['pending', 'used', 'skipped'])->default('pending');
            $table->integer('relevance_score')->default(0);
            $table->timestamps();

            $table->index('status');
            $table->index('fetched_at');
            $table->index('relevance_score');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('forex_raw_articles');
    }
};
