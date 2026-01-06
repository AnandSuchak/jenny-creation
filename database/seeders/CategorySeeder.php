<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => '2 Jar Box', 'filter_tag' => 'box'],
            ['name' => '3 Jar Box', 'filter_tag' => 'box'],
            ['name' => '4 Jar Box', 'filter_tag' => 'box'],
            ['name' => '6 Jar Box', 'filter_tag' => 'box'],
            ['name' => 'Puttha Box', 'filter_tag' => 'puttha'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category['name']],
                [
                    'slug'       => Str::slug($category['name']),
                    'filter_tag' => $category['filter_tag'],
                    'is_active'  => true,
                ]
            );
        }
    }
}
