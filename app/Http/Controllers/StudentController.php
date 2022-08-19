<?php

namespace App\Http\Controllers;

use App\Http\Requests\Student\CreateRequest;
use App\Http\Requests\Student\UpdateRequest;
use App\Http\Resources\StudentResource;
use App\Models\Classroom;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;



class StudentController extends Controller
{

    public function all(): ResourceCollection
    {
        $students = Student::all();

        return StudentResource::collection($students);
    }

    public function show(Student $student): jsonResponse
    {
        $lectures = $this->getLectures($student->id);
       // $classroom = $this->getClassRoom($student->id);
        $students = Student::with(['classroom'])->find($student->id);

        return response()->json([
            //'name' => $student->name,
           // 'email' => $student->email,
            'student' => $students->name,
            'email' => $students->email,
            'classroom' => $students->classroom_id,
            'lectures' => $lectures,
        ]);
    }

    public function create(CreateRequest $request): jsonResponse
    {
        $data = $request->validated();

        Student::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'classroom_id' => $data['classroom_id'],
        ]);

        return response()->json([
            'status' => true,
        ]);
    }

    public function update(UpdateRequest $request, int $id): jsonResponse
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

    public function delete(int $id)
    {
        Student::destroy($id);
        return response()->json([
            'status' => true
        ]);
    }

    private function getLectures(int $id)
    {
        return Student::join('classrooms', 'students.classroom_id', '=', 'classrooms.id')
            ->join('classroom_lectures', 'classrooms.id', '=', 'classroom_lectures.classroom_id')
            ->join('lectures', 'classroom_lectures.lecture_id', '=', 'lectures.id')
            ->where('students.id', '=', $id)
            ->select(['lectures.topic'])
            ->pluck('lectures.topic');
    }

    private function getClassRoom(int $id)
    {
        return Student::Join('classrooms', 'students.classroom_id', '=', 'classrooms.id')
            ->where('students.id', '=', $id)
            ->select(['classrooms.name as classroom_name'])
            ->value('classrooms.classroom_name');
    }

}
