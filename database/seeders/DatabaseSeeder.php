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
                'code' => 'MED-001',
                'description' => 'Folding stretcher for victim evacuation, good condition and ready to use',
                'category' => 'Medical',
                'total_quantity' => 5,
                'available_quantity' => 5,
                'condition' => 'Good',
            ],
            [
                'name' => 'Complete First Aid Kit',
                'code' => 'MED-002',
                'description' => 'First aid kit with complete medical supplies',
                'category' => 'Medical',
                'total_quantity' => 10,
                'available_quantity' => 10,
                'condition' => 'Good',
            ],
            [
                'name' => 'Digital Blood Pressure Monitor',
                'code' => 'MED-003',
                'description' => 'Digital blood pressure measuring device',
                'category' => 'Medical',
                'total_quantity' => 3,
                'available_quantity' => 3,
                'condition' => 'Good',
            ],
            [
                'name' => 'Dome Tent',
                'code' => 'LOG-001',
                'description' => 'Dome tent capacity 4 people for field activities',
                'category' => 'Logistics',
                'total_quantity' => 8,
                'available_quantity' => 8,
                'condition' => 'Good',
            ],
            [
                'name' => 'Sleeping Bag',
                'code' => 'LOG-002',
                'description' => 'Sleeping bag for camping activities',
                'category' => 'Logistics',
                'total_quantity' => 15,
                'available_quantity' => 15,
                'condition' => 'Good',
            ],
            [
                'name' => 'Portable Stove',
                'code' => 'LOG-003',
                'description' => 'Portable stove with gas cylinder',
                'category' => 'Logistics',
                'total_quantity' => 4,
                'available_quantity' => 4,
                'condition' => 'Good',
            ],
            [
                'name' => 'CPR Manikin',
                'code' => 'TRN-001',
                'description' => 'Manikin for Cardiopulmonary Resuscitation training',
                'category' => 'Training',
                'total_quantity' => 6,
                'available_quantity' => 6,
                'condition' => 'Good',
            ],
            [
                'name' => 'Spinal Board',
                'code' => 'TRN-002',
                'description' => 'Spinal board for victim evacuation training',
                'category' => 'Training',
                'total_quantity' => 3,
                'available_quantity' => 3,
                'condition' => 'Good',
            ],
            [
                'name' => 'Portable Sound System',
                'code' => 'EVT-001',
                'description' => 'Portable sound system for outdoor events',
                'category' => 'Event',
                'total_quantity' => 2,
                'available_quantity' => 2,
                'condition' => 'Good',
            ],
            [
                'name' => 'KSR PMI Standing Banner',
                'code' => 'EVT-002',
                'description' => 'Standing banner with KSR PMI Polines logo',
                'category' => 'Event',
                'total_quantity' => 5,
                'available_quantity' => 5,
                'condition' => 'Good',
            ],
            [
                'name' => 'Megaphone',
                'code' => 'EVT-003',
                'description' => 'Megaphone for event coordination',
                'category' => 'Event',
                'total_quantity' => 3,
                'available_quantity' => 3,
                'condition' => 'Good',
            ],
            [
                'name' => 'Large Tarpaulin',
                'code' => 'LOG-004',
                'description' => 'Tarpaulin size 4x6 meters',
                'category' => 'Logistics',
                'total_quantity' => 6,
                'available_quantity' => 6,
                'condition' => 'Good',
            ],
        ];

        foreach ($items as $item) {
            Item::create($item);
        }
    }
}
