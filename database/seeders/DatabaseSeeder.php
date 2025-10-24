<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Item;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin KSR PMI',
            'email' => 'admin@ksrpmi.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Staff User
        User::create([
            'name' => 'Staff KSR PMI',
            'email' => 'staff@ksrpmi.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
        ]);

        // Create Sample Items
        $items = [
            [
                'name' => 'Folding Stretcher',
                'description' => 'Folding stretcher for victim evacuation, good condition and ready to use',
                'category' => 'Medical',
                'total_quantity' => 5,
                'available_quantity' => 5,
                'price' => 50000,
                'condition' => 'Good',
            ],
            [
                'name' => 'Complete First Aid Kit',
                'description' => 'First aid kit with complete medical supplies',
                'category' => 'Medical',
                'total_quantity' => 10,
                'available_quantity' => 10,
                'price' => 25000,
                'condition' => 'Good',
            ],
            [
                'name' => 'Digital Blood Pressure Monitor',
                'description' => 'Digital blood pressure measuring device',
                'category' => 'Medical',
                'total_quantity' => 3,
                'available_quantity' => 3,
                'price' => 35000,
                'condition' => 'Good',
            ],
            [
                'name' => 'Dome Tent',
                'description' => 'Dome tent capacity 4 people for field activities',
                'category' => 'Logistics',
                'total_quantity' => 8,
                'available_quantity' => 8,
                'price' => 75000,
                'condition' => 'Good',
            ],
            [
                'name' => 'Sleeping Bag',
                'description' => 'Sleeping bag for camping activities',
                'category' => 'Logistics',
                'total_quantity' => 15,
                'available_quantity' => 15,
                'price' => 20000,
                'condition' => 'Good',
            ],
            [
                'name' => 'Portable Stove',
                'description' => 'Portable stove with gas cylinder',
                'category' => 'Logistics',
                'total_quantity' => 4,
                'available_quantity' => 4,
                'price' => 30000,
                'condition' => 'Good',
            ],
            [
                'name' => 'CPR Manikin',
                'description' => 'Manikin for Cardiopulmonary Resuscitation training',
                'category' => 'Training',
                'total_quantity' => 6,
                'available_quantity' => 6,
                'price' => 100000,
                'condition' => 'Good',
            ],
            [
                'name' => 'Spinal Board',
                'description' => 'Spinal board for victim evacuation training',
                'category' => 'Training',
                'total_quantity' => 3,
                'available_quantity' => 3,
                'price' => 60000,
                'condition' => 'Good',
            ],
            [
                'name' => 'Portable Sound System',
                'description' => 'Portable sound system for outdoor events',
                'category' => 'Event',
                'total_quantity' => 2,
                'available_quantity' => 2,
                'price' => 150000,
                'condition' => 'Good',
            ],
            [
                'name' => 'KSR PMI Standing Banner',
                'description' => 'Standing banner with KSR PMI Polines logo',
                'category' => 'Event',
                'total_quantity' => 5,
                'available_quantity' => 5,
                'price' => 15000,
                'condition' => 'Good',
            ],
            [
                'name' => 'Megaphone',
                'description' => 'Megaphone for event coordination',
                'category' => 'Event',
                'total_quantity' => 3,
                'available_quantity' => 3,
                'price' => 40000,
                'condition' => 'Good',
            ],
            [
                'name' => 'Large Tarpaulin',
                'description' => 'Tarpaulin size 4x6 meters',
                'category' => 'Logistics',
                'total_quantity' => 6,
                'available_quantity' => 6,
                'price' => 25000,
                'condition' => 'Good',
            ],
        ];

        foreach ($items as $item) {
            Item::create($item);
        }
    }
}
