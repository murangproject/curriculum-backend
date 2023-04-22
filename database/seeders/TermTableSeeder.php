<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TermTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('terms')->insert([
            'name' => 'First Semester',
        ]);
        DB::table('terms')->insert([
            'name' => 'Second Semester',
        ]);
        DB::table('terms')->insert([
            'name' => 'Third Semester',
        ]);
        DB::table('terms')->insert([
            'name' => 'Fourth Semester',
        ]);
    }
}
