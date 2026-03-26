<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EbookOrder extends Model
{
    protected $fillable = [
        'order_number',
        'ebook_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'payment_method',
        'payment_proof',
        'amount',
        'currency',
        'status',
        'admin_note',
        'approved_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'approved_at' => 'datetime',
    ];

    public function ebook()
    {
        return $this->belongsTo(Ebook::class);
    }

    public static function generateOrderNumber()
    {
        do {
            $number = 'EB-' . strtoupper(uniqid());
        } while (self::where('order_number', $number)->exists());

        return $number;
    }
}
