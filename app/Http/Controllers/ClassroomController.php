<?php

namespace App\Http\Controllers;

use App\Http\Requests\Classroom\CreateRequests;
use App\Models\Classroom;
use App\Models\ClassroomLecture;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Integer;


class ClassroomController extends Controller
{

    public function all(): JsonResponse
    {
        $classrooms = Classroom::pluck('name');
        return response()->json([
            'classrooms' => $classrooms,
        ]);
    }

    public function show(Classroom $classroom): JsonResponse
    {
        $students = Student::where('classroom_id', $classroom->id)->pluck('name');
        return response()->json([
            'classroomName' => $classroom->name,
            'students' => $students,
        ]);
    }

    public function curriculum(Classroom $classroom): JsonResponse
    {
        $lectures = Classroom::leftJoin('classroom_lectures', 'classrooms.id', '=', 'classroom_lectures.classroom_id')
            ->leftJoin('lectures', 'classroom_lectures.lecture_id', '=', 'lectures.id')
            ->where('classrooms.id', '=', $classroom->id)
            ->pluck('lectures.topic');

        return response()->json([
            'list of lectures' => $lectures,
        ]);
    }

    public function createClassroom(CreateRequests $requests): JsonResponse
    {
        $data = $requests->validated();
        Classroom::create([
            'name' => $data['name']
        ]);

        return response()->json([
            'status' => true,
        ]);
    }

    public function update(CreateRequests $requests, Classroom $classroom): JsonResponse
    {
        $data = $requests->validated();
        $classroom->update($data);

        return response()->json([
            'status' => true,
        ]);
    }

    public function delete(Integer $id): JsonResponse
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
