<?php

use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'student'], function (){
    Route::get('/all', [StudentController::class, 'all']); //получить список всех студентов
    Route::get('/show/{student}', [StudentController::class, 'show']); //получить инф о конкретном студенте(имя, емайл, класс, лекции)
    Route::post('/create', [StudentController::class, 'create']); //создать студента
    Route::post('/update/{id}', [StudentController::class, 'update']); //обновить студента(имя, принадлежность к классу)
    Route::delete('/delete/{id}', [StudentController::class, 'delete']); //удалить студента
});

Route::group(['prefix' => 'classroom'], function (){
    Route::get('/all', [ClassroomController::class, 'all']); //получить список классов
    Route::get('/show/{classroom}', [ClassroomController::class, 'show']); //получить информацию о конкретном классе(название, студенты)
    Route::get('/list/{classroom}', [ClassroomController::class, 'curriculum']); //получить учебный план (список лекций) для конкретного класса
    //Route::post('/create', [ClassroomController::class, 'create']); //создать/обновить учебный план (очередность и состав лекций) для конкретного класса
    Route::post('/create/classroom', [ClassroomController::class, 'createClassroom']); //создать класс
    Route::put('/update/{classroom}', [ClassroomController::class, 'update']); //обновить класс (название)
    Route::delete('/delete/{id}', [ClassroomController::class, 'delete']); //удалить класс (при удалении класса, привязанные студенты должны открепляться от класса, но не удаляться полностью из системы)
});
