<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;
    protected $table = 'classrooms';
    protected $fillable = ['name'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'class_id', 'id');
    }
    public function lectures()
    {
        return $this->belongsToMany(Lecture::class, 'classroom_lectures', 'classroom_id', 'lecture_id');
    }
}
