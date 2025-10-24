<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'code_number',
        'borrower_name',
        'phone',
        'organization',
        'borrow_date',
        'return_date',
        'total_days',
        'total_cost',
        'purpose',
        'spj',
        'status',
        'admin_notes',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'borrow_date' => 'date',
        'return_date' => 'date',
        'approved_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($borrowing) {
            if (empty($borrowing->code_number)) {
                $borrowing->code_number = static::generateCodeNumber();
            }
        });
    }

    public static function generateCodeNumber()
    {
        $year = date('Y');
        $lastBorrowing = static::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        if ($lastBorrowing && $lastBorrowing->code_number) {
            $lastNumber = (int) substr($lastBorrowing->code_number, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $year . '-PJM-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    public function items()
    {
        return $this->belongsToMany(Item::class, 'borrowing_items')
            ->withPivot('quantity', 'price_per_day')
            ->withTimestamps();
    }

    public function borrowingItems()
    {
        return $this->hasMany(BorrowingItem::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
}
