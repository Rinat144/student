<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentResource;
use App\Models\Classroom;
use App\Models\Student;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Collection;

class StudentController extends Controller
{
    public function all()
    {
        $students = Student::pluck('name');
        return response()->json([
            'name' => $students,
        ]);
    }
    public function show(Student $student)
    {
        $lectures = Student::leftJoin('classrooms', 'students.classroom_id', '=', 'classrooms.id')
            ->leftJoin('classroom_lectures', 'classrooms.id', '=', 'classroom_lectures.classroom_id')
            ->leftJoin('lectures', 'classroom_lectures.lecture_id', '=', 'lectures.id')
            ->where('students.id', '=', $student->id)
            ->get(['students.id', 'students.name', 'students.email', 'classrooms.name as classroom_name', 'lectures.topic']);

        return StudentResource::collection($lectures);
    }
}
