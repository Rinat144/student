<?php

use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'student'], function (){
    Route::get('/all', [StudentController::class, 'all']); //получить список всех студентов
});
