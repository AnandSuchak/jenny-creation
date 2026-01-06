<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            [
                'name' => 'Main Shop',
                'code' => 'SHOP',
                'description' => 'Primary retail location',
            ],
            [
                'name' => 'Back Storage',
                'code' => 'STORE',
                'description' => 'Secondary storage facility',
            ],
        ];

        foreach ($locations as $location) {
            Location::firstOrCreate(
                ['code' => $location['code']],
                [
                    'name'        => $location['name'],
                    'description' => $location['description'],
                    'is_active'   => true,
                ]
            );
        }
    }
}
