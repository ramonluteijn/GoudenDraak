<?php

namespace Database\Seeders\History;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OldUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = DB::table('OldUsers')->get();

        foreach ($users as $user) {
            $newUser = User::create([
                'name' => $user->id,
                'password' => bcrypt($user->wachtwoord),
            ]);
            $newUser->assignRole($user->isAdmin ? 'admin' : 'user');
        }
    }
}
