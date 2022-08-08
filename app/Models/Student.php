<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $table = 'students';
    protected $fillable = ['name', 'email', 'classroom_id'];

    public function classroom()
    {
        return $this->hasOne(Classroom::class, 'id', 'class_id');
    }
}
