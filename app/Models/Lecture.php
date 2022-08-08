<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    use HasFactory;
    protected $table = 'lectures';
    protected $fillable = ['topic', 'description'];

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, 'classroom_lectures', 'lecture_id', 'classroom_id');
    }
}
