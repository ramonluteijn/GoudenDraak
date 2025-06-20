<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menuItems = [
            [
                'name' => 'Home',
                'url' => '/',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nieuws',
                'url' => '/news',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Contact',
                'url' => '/contact',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Winkelwagen',
                'url' => '/cart',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($menuItems as $item) {
            \App\Models\MenuItem::updateOrInsert($item);
        }
    }
}
