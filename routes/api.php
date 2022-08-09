<?php

use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'student'], function (){
    Route::get('/all', [StudentController::class, 'all']); //получить список всех студентов
    Route::get('/show/{student}', [StudentController::class, 'show']); //получить инф о конкретном студенте(имя, емайл, класс, лекции)
    Route::post('/create', [StudentController::class, 'create']); //создать студента
    Route::post('/update/{id}', [StudentController::class, 'update']); //обновить студента(имя, принадлежность к классу)
});
