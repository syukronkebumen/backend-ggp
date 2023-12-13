<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterUom extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('master_uom')->insert([
            'name' => 'PCS'
        ]);

        DB::table('master_uom')->insert([
            'name' => 'PCL'
        ]);

        DB::table('master_uom')->insert([
            'name' => 'SET'
        ]);

        DB::table('master_uom')->insert([
            'name' => 'BH'
        ]);
    }
}
