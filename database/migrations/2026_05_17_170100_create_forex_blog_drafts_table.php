<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('forex_blog_drafts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('raw_article_id')->constrained('forex_raw_articles')->onDelete('cascade');
            $table->string('ai_title');
            $table->longText('ai_content');
            $table->text('ai_excerpt')->nullable();
            $table->json('ai_tags')->nullable();
            $table->string('ai_meta_description')->nullable();
            $table->text('lead_cta')->nullable();
            $table->enum('status', ['draft', 'approved', 'rejected', 'published'])->default('draft');
            $table->foreignId('moderator_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->text('reject_reason')->nullable();
            $table->foreignId('post_id')->nullable()->constrained('posts')->nullOnDelete();
            $table->string('generation_model')->nullable();
            $table->integer('generation_tokens')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('forex_blog_drafts');
    }
};
