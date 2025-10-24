<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowingItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'borrowing_id',
        'item_id',
        'quantity',
        'price_per_day',
    ];

    public function borrowing()
    {
        return $this->belongsTo(Borrowing::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function getSubtotalAttribute()
    {
        return $this->quantity * $this->price_per_day * $this->borrowing->total_days;
    }
}
