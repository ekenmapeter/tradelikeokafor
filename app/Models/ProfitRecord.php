<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProfitRecord extends Model
{
    use HasFactory;

    protected $table = 'profit_records';

    protected $fillable = [
        'reference_id',
        'student_id',
        'student_name',
        'profit_amount',
        'commission_received',
        'currency',
        'reason',
        'admin_id',
        'ip_address',
    ];

    /**
     * Get the student associated with the profit record.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Get the admin who created the record.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Get the evidence screenshots for the record.
     */
    public function evidences(): HasMany
    {
        return $this->hasMany(ProfitEvidence::class);
    }

    /**
     * Get the display name for the student.
     */
    public function getStudentDisplayNameAttribute(): string
    {
        return $this->student ? $this->student->name : ($this->student_name ?? 'N/A');
    }

    /**
     * Generate a unique reference ID.
     */
    public static function generateReferenceId(): string
    {
        $prefix = 'PR-' . date('Ymd') . '-';
        $latest = self::where('reference_id', 'like', $prefix . '%')
            ->orderBy('reference_id', 'desc')
            ->first();

        if (!$latest) {
            return $prefix . '0001';
        }

        $lastNumber = (int) substr($latest->reference_id, -4);
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        return $prefix . $newNumber;
    }
}
