<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfitEvidence extends Model
{
    use HasFactory;

    protected $table = 'profit_evidences';

    protected $fillable = [
        'profit_record_id',
        'file_path',
        'file_name',
    ];

    /**
     * Get the profit record that owns the evidence.
     */
    public function profitRecord(): BelongsTo
    {
        return $this->belongsTo(ProfitRecord::class);
    }
}
