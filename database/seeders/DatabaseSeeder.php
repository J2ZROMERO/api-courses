<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Element;
use App\Models\Section;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = Role::updateOrCreate(
            ['name' => 'admin']
        );

        $student = Role::updateOrCreate(
            ['name' => 'student']
        );

        $teacher = Role::updateOrCreate(
            ['name' => 'teacher']
        );

        $student_user = User::updateOrCreate(
        [
            'email' => 'student@example.com'
        ],
        [
            'name' => 'Test User Student',
            'password' => Hash::make('password')
        ]);

        $teacher_user = User::updateOrCreate(
        [
            'email' => 'teacher@example.com'
        ],
        [
            'name' => 'Test User Teacher',
            'password' => Hash::make('password')
        ]);

        $admin_user = User::updateOrCreate(
        [
            'email' => 'admin@example.com'
        ],
        [
            'name' => 'Test User Admin',
            'password' => Hash::make('password')
        ]);

        $student_user->assignRole('student');
        $admin_user->assignRole('admin');
        $teacher_user->assignRole('teacher');

        $course_one = Course::updateOrCreate(
        [
            'title' => 'Introduccion'
        ],
        [
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor 
            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco 
            laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate 
            velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, 
            sunt in culpa qui officia deserunt mollit anim id est laborum',
            'created_by' => $teacher_user->id
        ]);

        $course_two = Course::updateOrCreate(
        [
            'title' => 'Laravel'
        ],
        [
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor 
            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco 
            laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate 
            velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, 
            sunt in culpa qui officia deserunt mollit anim id est laborum',
            'created_by' => $teacher_user->id
        ]);

        $course_three = Course::updateOrCreate(
        [
            'title' => 'Filosofia 1'
        ],
        [
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor 
            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco 
            laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate 
            velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, 
            sunt in culpa qui officia deserunt mollit anim id est laborum',
            'created_by' => $teacher_user->id
        ]);

        $section_1 = Section::updateOrCreate(
        [
            'title' => 'Curso 1 Seccion 1'
        ],
        [
            
            'course_id' => $course_one->id,
            'position' => 0
        ]);

        $section_2 = Section::updateOrCreate(
        [
            'title' => 'Curso 1 Seccion 2'
        ],
        [
            
            'course_id' => $course_one->id,
            'position' => 1
        ]);

        $section_3 = Section::updateOrCreate(
        [
            'title' => 'Curso 1 Seccion 3'
        ],
        [
            
            'course_id' => $course_one->id,
            'position' => 2
        ]);

        $section_4 = Section::updateOrCreate(
        [
            'title' => 'Curso 2 Seccion 1'
        ],
        [
            
            'course_id' => $course_two->id,
            'position' => 0
        ]);

        $section_5 = Section::updateOrCreate(
        [
            'title' => 'Curso 2 Seccion 2'
        ],
        [
            
            'course_id' => $course_two->id,
            'position' => 1
        ]);

        $section_6 = Section::updateOrCreate(
        [
            'title' => 'Curso 2 Seccion 3'
        ],
        [
            
            'course_id' => $course_two->id,
            'position' => 2
        ]);

        $section_7 = Section::updateOrCreate(
        [
            'title' => 'Curso 3 Seccion 1'
        ],
        [
            
            'course_id' => $course_three->id,
            'position' => 0
        ]);

        $section_8 = Section::updateOrCreate(
        [
            'title' => 'Curso 3 Seccion 2'
        ],
        [
            
            'course_id' => $course_three->id,
            'position' => 1
        ]);

        $section_9 = Section::updateOrCreate(
        [
            'title' => 'Curso 3 Seccion 3'
        ],
        [
            
            'course_id' => $course_three->id,
            'position' => 2
        ]);

        $element_a1 = Element::updateOrCreate(
        [
            'title' => 'Elemento A1'
        ],
        [
            
            'section_id' => $section_1->id,
            'position' => 0,
            'type' => 1,
            'url' => "https://www.youtube.com/watch?v=PGQxIILBb7M",
        ]);

        $element_a2 = Element::updateOrCreate(
        [
            'title' => 'Elemento A2'
        ],
        [
            
            'section_id' => $section_1->id,
            'position' => 1,
            'type' => 1,
            'url' => "https://www.youtube.com/watch?v=PGQxIILBb7M",
        ]);

        $element_a3 = Element::updateOrCreate(
        [
            'title' => 'Elemento A3'
        ],
        [
            
            'section_id' => $section_1->id,
            'position' => 2,
            'type' => 1,
            'url' => "https://www.youtube.com/watch?v=PGQxIILBb7M",
        ]);

        $element_a4 = Element::updateOrCreate(
        [
            'title' => 'Elemento A4'
        ],
        [
            
            'section_id' => $section_2->id,
            'position' => 0,
            'type' => 1,
            'url' => "https://www.youtube.com/watch?v=PGQxIILBb7M",
        ]);

        $element_a5 = Element::updateOrCreate(
        [
            'title' => 'Elemento A5'
        ],
        [
            
            'section_id' => $section_2->id,
            'position' => 1,
            'type' => 1,
            'url' => "https://www.youtube.com/watch?v=PGQxIILBb7M",
        ]);

        $element_a6 = Element::updateOrCreate(
        [
            'title' => 'Elemento A6'
        ],
        [
            
            'section_id' => $section_2->id,
            'position' => 2,
            'type' => 1,
            'url' => "https://www.youtube.com/watch?v=PGQxIILBb7M",
        ]);

        $element_a7 = Element::updateOrCreate(
        [
            'title' => 'Elemento A7'
        ],
        [
            
            'section_id' => $section_3->id,
            'position' => 0,
            'type' => 1,
            'url' => "https://www.youtube.com/watch?v=PGQxIILBb7M",
        ]);

        $element_a8 = Element::updateOrCreate(
        [
            'title' => 'Elemento A8'
        ],
        [
            
            'section_id' => $section_3->id,
            'position' => 1,
            'type' => 1,
            'url' => "https://www.youtube.com/watch?v=PGQxIILBb7M",
        ]);

        $element_a9 = Element::updateOrCreate(
        [
            'title' => 'Elemento A9'
        ],
        [
            
            'section_id' => $section_3->id,
            'position' => 2,
            'type' => 1,
            'url' => "https://www.youtube.com/watch?v=PGQxIILBb7M",
        ]);

        $element_b1 = Element::updateOrCreate(
        [
            'title' => 'Elemento B1'
        ],
        [
            
            'section_id' => $section_4->id,
            'position' => 0,
            'type' => 1,
            'url' => "https://www.youtube.com/watch?v=PGQxIILBb7M",
        ]);

        $element_b2 = Element::updateOrCreate(
        [
            'title' => 'Elemento b2'
        ],
        [
            
            'section_id' => $section_4->id,
            'position' => 1,
            'type' => 1,
            'url' => "https://www.youtube.com/watch?v=PGQxIILBb7M",
        ]);

        $element_b3 = Element::updateOrCreate(
        [
            'title' => 'Elemento b3'
        ],
        [
            
            'section_id' => $section_4->id,
            'position' => 2,
            'type' => 1,
            'url' => "https://www.youtube.com/watch?v=PGQxIILBb7M",
        ]);

        $element_b4 = Element::updateOrCreate(
        [
            'title' => 'Elemento b4'
        ],
        [
            
            'section_id' => $section_5->id,
            'position' => 0,
            'type' => 1,
            'url' => "https://www.youtube.com/watch?v=PGQxIILBb7M",
        ]);

        $element_b5 = Element::updateOrCreate(
        [
            'title' => 'Elemento b5'
        ],
        [
            
            'section_id' => $section_5->id,
            'position' => 1,
            'type' => 1,
            'url' => "https://www.youtube.com/watch?v=PGQxIILBb7M",
        ]);

        $element_b6 = Element::updateOrCreate(
        [
            'title' => 'Elemento b6'
        ],
        [
            
            'section_id' => $section_5->id,
            'position' => 2,
            'type' => 1,
            'url' => "https://www.youtube.com/watch?v=PGQxIILBb7M",
        ]);

        $element_b7 = Element::updateOrCreate(
        [
            'title' => 'Elemento b7'
        ],
        [
            
            'section_id' => $section_6->id,
            'position' => 0,
            'type' => 1,
            'url' => "https://www.youtube.com/watch?v=PGQxIILBb7M",
        ]);

        $element_b8 = Element::updateOrCreate(
        [
            'title' => 'Elemento b8'
        ],
        [
            
            'section_id' => $section_6->id,
            'position' => 1,
            'type' => 1,
            'url' => "https://www.youtube.com/watch?v=PGQxIILBb7M",
        ]);

        $element_b9 = Element::updateOrCreate(
        [
            'title' => 'Elemento b9'
        ],
        [
            
            'section_id' => $section_6->id,
            'position' => 2,
            'type' => 1,
            'url' => "https://www.youtube.com/watch?v=PGQxIILBb7M",
        ]);

        $element_c1 = Element::updateOrCreate(
        [
            'title' => 'Elemento c1'
        ],
        [
            
            'section_id' => $section_7->id,
            'position' => 0,
            'type' => 1,
            'url' => "https://www.youtube.com/watch?v=PGQxIILBb7M",
        ]);

        $element_c2 = Element::updateOrCreate(
        [
            'title' => 'Elemento c2'
        ],
        [
            
            'section_id' => $section_7->id,
            'position' => 1,
            'type' => 1,
            'url' => "https://www.youtube.com/watch?v=PGQxIILBb7M",
        ]);

        $element_c3 = Element::updateOrCreate(
        [
            'title' => 'Elemento c3'
        ],
        [
            
            'section_id' => $section_7->id,
            'position' => 2,
            'type' => 1,
            'url' => "https://www.youtube.com/watch?v=PGQxIILBb7M",
        ]);

        $element_c4 = Element::updateOrCreate(
        [
            'title' => 'Elemento c4'
        ],
        [
            
            'section_id' => $section_8->id,
            'position' => 0,
            'type' => 1,
            'url' => "https://www.youtube.com/watch?v=PGQxIILBb7M",
        ]);

        $element_c5 = Element::updateOrCreate(
        [
            'title' => 'Elemento c5'
        ],
        [
            
            'section_id' => $section_8->id,
            'position' => 1,
            'type' => 1,
            'url' => "https://www.youtube.com/watch?v=PGQxIILBb7M",
        ]);

        $element_c6 = Element::updateOrCreate(
        [
            'title' => 'Elemento c6'
        ],
        [
            
            'section_id' => $section_8->id,
            'position' => 2,
            'type' => 1,
            'url' => "https://www.youtube.com/watch?v=PGQxIILBb7M",
        ]);

        $element_c7 = Element::updateOrCreate(
        [
            'title' => 'Elemento c7'
        ],
        [
            
            'section_id' => $section_9->id,
            'position' => 0,
            'type' => 1,
            'url' => "https://www.youtube.com/watch?v=PGQxIILBb7M",
        ]);

        $element_c8 = Element::updateOrCreate(
        [
            'title' => 'Elemento c8'
        ],
        [
            
            'section_id' => $section_9->id,
            'position' => 1,
            'type' => 1,
            'url' => "https://www.youtube.com/watch?v=PGQxIILBb7M",
        ]);

        $element_c9 = Element::updateOrCreate(
        [
            'title' => 'Elemento c9'
        ],
        [
            
            'section_id' => $section_9->id,
            'position' => 2,
            'type' => 1,
            'url' => "https://www.youtube.com/watch?v=PGQxIILBb7M",
        ]);

    }
}
