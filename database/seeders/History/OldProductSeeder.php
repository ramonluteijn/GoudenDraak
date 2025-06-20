<?php

namespace Database\Seeders\History;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OldProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $oldProducts = DB::table('OldProducts')->get();

        foreach ($oldProducts as $oldProduct) {
            DB::table('categories')->insertOrIgnore([
                'name' => $oldProduct->soortgerecht,
            ]);

            DB::table('products')->insert([
                'name' => $oldProduct->naam,
                'price' => $oldProduct->price,
                'description' => $oldProduct->beschrijving,
                'category_id' => DB::table('categories')->where('name', $oldProduct->soortgerecht)->value('id'),
            ]);
        }
    }
}
