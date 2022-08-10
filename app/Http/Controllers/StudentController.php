<?php

namespace App\Http\Controllers;

use App\Http\Requests\Student\CreateRequest;
use App\Http\Requests\Student\UpdateRequest;
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
        $lectures = Student::rightJoin('classrooms', 'students.classroom_id', '=', 'classrooms.id')
            ->rightJoin('classroom_lectures', 'classrooms.id', '=', 'classroom_lectures.classroom_id')
            ->rightJoin('lectures', 'classroom_lectures.lecture_id', '=', 'lectures.id')
            ->where('students.id', '=', $student->id)
            ->select(['lectures.topic'])
            ->pluck('lectures.topic');
        $classroom = Student::Join('classrooms', 'students.classroom_id', '=', 'classrooms.id')
            ->where('students.id', '=', $student->id)
            ->select(['classrooms.name as classroom_name'])
            ->value('classrooms.classroom_name');

        return response()->json([
            'name' => $student->name,
            'email' => $student->email,
            'classroom' => $classroom,
            'lectures' => $lectures,
        ]);
    }

    public function create(CreateRequest $request)
    {
        $data = $request->validated();
        $classroom = Classroom::where('name', $data['classroom_id'])->first();
        Student::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'classroom_id' => $classroom->id,
        ]);

        return response()->json([
            'status' => true,
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        $data = $request->validated();
        $classroom = Classroom::where('name', $data['classroom_id'])
            ->value('id');

        Student::where('id', $id)->update([
            'name' => $data['name'],
            'classroom_id' => $classroom,
        ]);
        return response()->json([
            'status' => true,
        ]);
    }

    public function delete($id)
    {
        Student::destroy($id);
        return response()->json([
            'status' => true
        ]);
    }
}
