<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForexRawArticle extends Model
{
    use HasFactory;

    protected $fillable = [
        'source_name',
        'source_feed_url',
        'source_url',
        'raw_title',
        'raw_content',
        'raw_excerpt',
        'content_hash',
        'published_at',
        'fetched_at',
        'status',
        'relevance_score',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'fetched_at' => 'datetime',
    ];

    // ── Relationships ──

    public function drafts()
    {
        return $this->hasMany(ForexBlogDraft::class, 'raw_article_id');
    }

    // ── Scopes ──

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeUsed($query)
    {
        return $query->where('status', 'used');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('fetched_at', today());
    }

    public function scopeTopCandidates($query, int $limit = 10)
    {
        return $query->pending()
            ->orderByDesc('relevance_score')
            ->orderByDesc('published_at')
            ->limit($limit);
    }
}
