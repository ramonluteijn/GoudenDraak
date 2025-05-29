<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
        ]);

        User::insert([
                'name' => 'Admin',
                'email' => 'admin@goudendraak.nl',
                'password' => bcrypt('test1234'),
        ]);

        User::find(1)->assignRole('admin');
    }
}
