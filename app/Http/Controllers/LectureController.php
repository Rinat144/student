<?php

namespace App\Http\Controllers;

use App\Http\Requests\Lecture\CreateRequest;
use App\Models\ClassroomLecture;
use App\Models\Lecture;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Integer;

class LectureController extends Controller
{
    public function all(): JsonResponse
    {
        $lectures = Lecture::pluck('topic');
        return response()->json([
            'lectures' => $lectures,
        ]);
    }

    public function show(Lecture $lecture): JsonResponse
    {
        $classroom = Lecture::leftJoin('classroom_lectures', 'lectures.id', '=', 'classroom_lectures.lecture_id')
            ->leftJoin('classrooms', 'classroom_lectures.classroom_id', '=', 'classrooms.id')
            ->where('lectures.id', '=', $lecture->id)
            ->select(['classrooms.name as classrooms_name'])
            ->pluck('classrooms.classrooms_name');
        $students = Lecture::leftJoin('classroom_lectures', 'lectures.id', '=', 'classroom_lectures.lecture_id')
            ->leftJoin('classrooms', 'classroom_lectures.classroom_id', '=', 'classrooms.id')
            ->leftJoin('students', 'classrooms.id', '=', 'students.classroom_id')
            ->where('lectures.id', '=', $lecture->id)
            ->select(['students.name as student_name'])
            ->pluck('students.student_name');


        return response()->json([
            'topic' => $lecture->topic,
            'description' => $lecture->description,
            'classrooms' => $classroom,
            'students' => $students,
        ]);
    }

    public function create(CreateRequest $request): JsonResponse
    {
        $data = $request->validated();

        Lecture::insert([
            'topic' => $data['topic'],
            'description' => $data['description'],
        ]);

        return response()->json([
           'status' => true,
        ]);
    }

    public function put(CreateRequest $request, Lecture $lecture): JsonResponse
    {
        $data = $request->validated();
        $lecture->update($data);

        return response()->json([
           'status' => true,
        ]);
    }

    public function delete(Integer $id): JsonResponse
    {
        ClassroomLecture::where('lecture_id', '=', $id)->delete();
        Lecture::destroy($id);

        return response()->json([
           'status' => true,
        ]);
    }
}
