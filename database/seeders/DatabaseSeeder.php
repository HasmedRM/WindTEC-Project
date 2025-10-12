<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        DB::table('cliente')->insert([
                ['nome' => 'SUZLON'],
                ['nome' => 'GE'],
                ['nome' => 'ENERGIMP'],
                ['nome' => 'ESSENTIA ENERGIA'],
                ['nome' => 'NORDEX ACCIONA'],
                ['nome' => 'SANY'],
                ['nome' => 'ALSTOM'],
                ['nome' => 'SIEMENS GAMESA'],
                ['nome' => 'VESTAS'],
            ]
        );
        DB::table('')->insert([
            ['valor' => '80.00'],
            ['valor' => '84.00'],
            ['valor' => '85.00'],
            ['valor' => '90.00'],
            ['valor' => '100.00'],
            ['valor' => '110.00'],
            ['valor' => '120.00'],
            ['valor' => '125.00'],
            ['valor' => '126.00'],
            ['valor' => '140.00'],
        ]);
        DB::table('')->insert([

        ]);
    }
}
