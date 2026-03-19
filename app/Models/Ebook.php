<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ebook extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'cover_image',
        'pdf_file',
        'price',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function orders()
    {
        return $this->hasMany(EbookOrder::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ebook) {
            if (empty($ebook->slug)) {
                $ebook->slug = Str::slug($ebook->title);
            }
        });
    }
}
