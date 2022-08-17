<?php

namespace App\Http\Controllers;

use App\Http\Requests\Classroom\CreateRequests;
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

        return response()->json([
            'list of lectures' => $lectures,
        ]);
    }

    public function createClassroom(CreateRequests $requests)
    {
        $data = $requests->validated();
        Classroom::create([
            'name' => $data['name']
        ]);

        return response()->json([
            'status' => true,
        ]);
    }

    public function update(CreateRequests $requests, Classroom $classroom)
    {
        $data = $requests->validated();
        $classroom->update($data);

        return response()->json([
            'status' => true,
        ]);
    }

    public function delete($id)
    {
        Classroom::destroy($id);

        return response()->json([
           'status' => true,
        ]);
    }

    public function create(Classroom $classroom)
    {
        //
    }
}
