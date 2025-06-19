<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class HistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            History\OldProductSeeder::class,
            History\OldSalesSeeder::class,
//            History\OldUserSeeder::class, //turn off for now
        ]);

        $dropTables = [
            'OldProducts',
            'OldSales',
            'OldUsers',
            'menu_pdf',
            'specialiteiten',
            'rijst_enzo',

        ];
        foreach ($dropTables as $table) {
            if (Schema::hasTable($table)) {
                Schema::dropIfExists($table);
            }
        }
    }
}
