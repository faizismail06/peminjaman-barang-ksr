<?php

namespace Tests\Unit;

use App\Models\Item;
use PHPUnit\Framework\TestCase;

class ItemStockTest extends TestCase
{
    public function test_small_inventory_is_not_low_when_fully_available(): void
    {
        $item = new Item(['total_quantity' => 5, 'available_quantity' => 5]);

        $this->assertFalse($item->isLowStock());
        $this->assertSame(100, $item->stock_percentage);
    }

    public function test_inventory_is_low_at_twenty_percent_or_less(): void
    {
        $item = new Item(['total_quantity' => 5, 'available_quantity' => 1]);

        $this->assertTrue($item->isLowStock());
        $this->assertSame(20, $item->stock_percentage);
    }

    public function test_out_of_stock_is_not_duplicated_as_low_stock(): void
    {
        $item = new Item(['total_quantity' => 5, 'available_quantity' => 0]);

        $this->assertFalse($item->isLowStock());
        $this->assertSame(0, $item->stock_percentage);
    }
}
