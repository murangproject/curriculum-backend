<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Nette\Utils\Random;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            [
                'code' => 'CS101',
                'title' => 'Introduction to Computer Science',
                'description' => 'This is an introductory course to computer science.',
                'year_level' => 1,
                'term' => 1,
                'prerequisite_code' => '',
                'corequisite_code' => ''
            ],
            [
                'code' => 'CS102',
                'title' => 'Introduction to Programming',
                'description' => 'This is an introductory course to programming.',
                'year_level' => 1,
                'term' => 1,
                'prerequisite_code' => 'CS101',
                'corequisite_code' => ''
            ],
            [
                'code' => 'CS210',
                'title' => 'Data Structures',
                'description' => 'Study of data structures and their applications.',
                'year_level' => 2,
                'term' => 1,
                'prerequisite_code' => 'CS102',
                'corequisite_code' => ''
            ],
            [
                'code' => 'CS220',
                'title' => 'Algorithms',
                'description' => 'Introduction to algorithms and algorithm analysis.',
                'year_level' => 2,
                'term' => 2,
                'prerequisite_code' => 'CS210',
                'corequisite_code' => ''
            ],
            // ...
        ];

        $subjects = array_merge($subjects, [
            [
                'code' => 'CS301',
                'title' => 'Operating Systems',
                'description' => 'Study of operating system concepts and design.',
                'year_level' => 3,
                'term' => 1,
                'prerequisite_code' => 'CS220',
                'corequisite_code' => ''
            ],
            [
                'code' => 'CS310',
                'title' => 'Computer Networks',
                'description' => 'Introduction to computer networks and their protocols.',
                'year_level' => 3,
                'term' => 1,
                'prerequisite_code' => 'CS220',
                'corequisite_code' => 'CS301'
            ],
            [
                'code' => 'CS320',
                'title' => 'Database Systems',
                'description' => 'Introduction to database systems and their design.',
                'year_level' => 3,
                'term' => 2,
                'prerequisite_code' => 'CS210',
                'corequisite_code' => ''
            ],
            [
                'code' => 'CS330',
                'title' => 'Software Engineering',
                'description' => 'Study of software engineering principles and methodologies.',
                'year_level' => 3,
                'term' => 2,
                'prerequisite_code' => 'CS210',
                'corequisite_code' => 'CS320'
            ],
            [
                'code' => 'CS401',
                'title' => 'Artificial Intelligence',
                'description' => 'Introduction to artificial intelligence concepts and techniques.',
                'year_level' => 4,
                'term' => 1,
                'prerequisite_code' => 'CS220',
                'corequisite_code' => ''
            ],
            [
                'code' => 'CS410',
                'title' => 'Computer Graphics',
                'description' => 'Introduction to computer graphics and rendering techniques.',
                'year_level' => 4,
                'term' => 1,
                'prerequisite_code' => 'CS210',
                'corequisite_code' => ''
            ],
            [
                'code' => 'CS420',
                'title' => 'Web Development',
                'description' => 'Study of web development technologies and best practices.',
                'year_level' => 4,
                'term' => 1,
                'prerequisite_code' => 'CS320',
                'corequisite_code' => ''
            ],
            [
                'code' => 'CS430',
                'title' => 'Mobile Application Development',
                'description' => 'Introduction to mobile application development for various platforms.',
                'year_level' => 4,
                'term' => 2,
                'prerequisite_code' => 'CS320',
                'corequisite_code' => 'CS420'
            ],
            [
                'code' => 'CS440',
                'title' => 'Cybersecurity',
                'description' => 'Introduction to cybersecurity concepts and practices.',
                'year_level' => 4,
                'term' => 2,
                'prerequisite_code' => 'CS310',
                'corequisite_code' => ''
            ],
            [
                'code' => 'CS450',
                'title' => 'Cloud Computing',
                'description' => 'Introduction to cloud computing technologies and services.',
                'year_level' => 4,
                'term' => 2,
                'prerequisite_code' => 'CS310',
                'corequisite_code' => ''
            ],
        ]);

        foreach ($subjects as $subject) {
            DB::table('subjects')->insert([
                'code' => $subject['code'],
                'title' => $subject['title'],
                'description' => $subject['description'],
                'units' => rand(1, 5),
                'hours' => rand(1, 8),
                'year_level' => $subject['year_level'],
                'term' => $subject['term'],
            ]);
        }
    }
}
