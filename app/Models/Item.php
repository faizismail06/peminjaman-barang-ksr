<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

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
}
