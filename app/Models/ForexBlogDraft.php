<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForexBlogDraft extends Model
{
    use HasFactory;

    protected $fillable = [
        'raw_article_id',
        'ai_title',
        'ai_content',
        'ai_excerpt',
        'ai_tags',
        'ai_meta_description',
        'lead_cta',
        'status',
        'moderator_id',
        'reviewed_at',
        'published_at',
        'reject_reason',
        'post_id',
        'generation_model',
        'generation_tokens',
    ];

    protected $casts = [
        'ai_tags' => 'array',
        'reviewed_at' => 'datetime',
        'published_at' => 'datetime',
    ];

    // ── Relationships ──

    public function rawArticle()
    {
        return $this->belongsTo(ForexRawArticle::class, 'raw_article_id');
    }

    public function moderator()
    {
        return $this->belongsTo(User::class, 'moderator_id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // ── Scopes ──

    public function scopeDrafts($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    // ── Accessors ──

    public function getParsedTagsAttribute(): array
    {
        return is_array($this->ai_tags) ? $this->ai_tags : [];
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'draft' => 'bg-yellow-100 text-yellow-800',
            'approved' => 'bg-blue-100 text-blue-800',
            'rejected' => 'bg-red-100 text-red-800',
            'published' => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}
