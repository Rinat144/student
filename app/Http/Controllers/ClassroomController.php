<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Student;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function all()
    {
        $classrooms = Classroom::pluck('name');
        return response()->json([
           'classrooms' => $classrooms,
        ]);
    }

    public function show(Classroom $classroom)
    {
        $students = Student::where('classroom_id', $classroom->id)->pluck('name');
        return response()->json([
            'classroomName' => $classroom->name,
            'students' => $students,
        ]);
    }

    public function curriculum(Classroom $classroom)
    {
      $lectures = Classroom::leftJoin('classroom_lectures', 'classrooms.id', '=', 'classroom_lectures.classroom_id')
      ->leftJoin('lectures', 'classroom_lectures.lecture_id', '=', 'lectures.id')
      ->where('classrooms.id', '=', $classroom->id)
          ->pluck('lectures.topic');

      dd($lectures);
    }
}
