<?php

namespace App\Http\Controllers;

use App\Http\Requests\Lecture\CreateRequest;
use App\Http\Resources\LectureResource;
use App\Models\ClassroomLecture;
use App\Models\Lecture;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;

class LectureController extends Controller
{
    public function all(): ResourceCollection
    {
        $lectures = Lecture::all();

        return LectureResource::collection($lectures);
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
        $lect = new Lecture();
        $lect->topic = $data['topic'];

        Lecture::create($data);

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

    public function delete(int $id): JsonResponse
    {
        try {
            DB::beginTransaction();
            ClassroomLecture::where('lecture_id', '=', $id)->delete();
            Lecture::destroy($id);
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            return response()->json([
                'status' => $exception,
            ]);
        }

        return response()->json([
           'status' => true,
        ]);
    }
}
