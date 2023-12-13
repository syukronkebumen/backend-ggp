<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('master_departement')->insert([
            'departement' => 'Packaging'
        ]);

        DB::table('master_departement')->insert([
            'departement' => 'Central'
        ]);

        DB::table('master_departement')->insert([
            'departement' => 'Sparepart'
        ]);
    }
}
