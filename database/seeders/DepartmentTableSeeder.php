<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'code' => 'CS',
                'name' => 'Computer Science',
                'description' => 'The Computer Science program focuses on the theoretical foundation of computing, algorithms, and software development.',
            ],
            [
                'code' => 'IT',
                'name' => 'Information Technology',
                'description' => 'The Information Technology program emphasizes practical skills in computing, networking, and database management.',
            ],
            [
                'code' => 'IS',
                'name' => 'Information Systems',
                'description' => 'The Information Systems program deals with the design and implementation of information systems for businesses and organizations.',
            ],
            [
                'code' => 'CT',
                'name' => 'Computing Technology',
                'description' => 'The Computing Technology program covers a broad range of computing topics, including hardware, software, and systems integration.',
            ],
        ];

        foreach ($departments as $department) {
            DB::table('departments')->insert([
                'code' => $department['code'],
                'name' => $department['name'],
                'description' => $department['description'],
            ]);
        }
    }
}
