<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    public const LOW_STOCK_PERCENTAGE = 20;

    protected $fillable = [
        'name',
        'description',
        'category',
        'total_quantity',
        'available_quantity',
        'price',
        'condition',
        'photo',
    ];

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    public function isAvailable($quantity)
    {
        return $this->available_quantity >= $quantity;
    }

    public function isLowStock(): bool
    {
        if ($this->total_quantity <= 0 || $this->available_quantity <= 0) {
            return false;
        }

        return ($this->available_quantity * 100)
            <= ($this->total_quantity * self::LOW_STOCK_PERCENTAGE);
    }

    public function getStockPercentageAttribute(): int
    {
        if ($this->total_quantity <= 0) {
            return 0;
        }

        return (int) round(($this->available_quantity / $this->total_quantity) * 100);
    }

    public function scopeLowStock($query)
    {
        return $query
            ->where('total_quantity', '>', 0)
            ->where('available_quantity', '>', 0)
            ->whereRaw(
                'available_quantity * 100 <= total_quantity * ?',
                [self::LOW_STOCK_PERCENTAGE]
            );
    }
}
