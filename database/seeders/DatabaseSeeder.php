<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Classroom;
use App\Models\Lecture;
use App\Models\Student;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $classrooms = Classroom::factory(7)->create();
        Student::factory(75)->create();
        $lectures = Lecture::factory(40)->create();

        foreach ($classrooms as $classroom) {
            $lecturesId = $lectures->random(6)->pluck('id');
            $classroom->lectures()->attach($lecturesId);
        }
    }
}
