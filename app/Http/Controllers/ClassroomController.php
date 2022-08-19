<?php

namespace App\Http\Controllers;

use App\Http\Requests\Classroom\CreateRequests;
use App\Http\Resources\ClassroomResource;
use App\Models\Classroom;
use App\Models\ClassroomLecture;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;


class ClassroomController extends Controller
{
    public function all(): ResourceCollection
    {
        $classrooms = Classroom::all();
        return ClassroomResource::collection($classrooms);
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

    public function delete(int $id): JsonResponse
    {
        try {
            DB::beginTransaction();
            Student::where('classroom_id', '=', $id)
                ->update([
                    'classroom_id' => null
                ]);
            ClassroomLecture::where('classroom_id', '=', $id)
                ->delete();
            Classroom::destroy($id);
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

    public function create(Classroom $classroom)
    {
        //
    }
}
