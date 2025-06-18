<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Home',
                'url' => 'home',
                'content' => 'Home',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Contact',
                'url' => 'contact',
                'content' => 'Contact',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Nieuws',
                'url' => 'news',
                'content' => 'Nieuws',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($pages as $page) {
            \App\Models\Page::updateOrInsert($page);
        }
    }
}
