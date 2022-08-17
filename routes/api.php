<?php

use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\LectureController;
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
    Route::put('/create/{classroom}', [ClassroomController::class, 'create']); //updateOrInsert //создать/обновить учебный план (очередность и состав лекций) для конкретного класса
    Route::post('/create/classroom', [ClassroomController::class, 'createClassroom']); //создать класс
    Route::put('/update/{classroom}', [ClassroomController::class, 'update']); //обновить класс (название)
    Route::delete('/delete/{id}', [ClassroomController::class, 'delete']); //удалить класс (при удалении класса, привязанные студенты должны открепляться от класса, но не удаляться полностью из системы)
});

Route::group(['prefix' => 'lecture'], function (){
    Route::get('/all', [LectureController::class, 'all']); //получить список всех лекций
    Route::get('/show/{lecture}', [LectureController::class, 'show']); //получить информацию о конкретной лекции (тема, описание + какие классы прослушали лекцию + какие студенты прослушали лекцию)
    Route::post('/create', [LectureController::class, 'create']); //создать лекцию
    Route::put('/put/{lecture}', [LectureController::class, 'put']); //обновить лекцию (тема, описание)
    Route::delete('/delete/{id}', [LectureController::class, 'delete']); //удалить лекцию
});
