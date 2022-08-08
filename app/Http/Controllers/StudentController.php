<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Collection;

class StudentController extends Controller
{
    public function all()
    {
        $students = Student::pluck('name');

        }
    }
}
