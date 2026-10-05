<?php

use App\Http\Controllers\UsersController;
use App\Http\Controllers\CountiesController;
use App\Http\Controllers\CitiesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// https://www.youtube.com/watch?v=FoaaTN2i8QY

Route::post('/users/login', [UsersController::class, 'login']);
Route::get('/users', [UsersController::class, 'index'])
    ->middleware('auth:sanctum'); // => authentication middleware !!!

Route::get('/counties', [CountiesController::class, 'index']);
Route::post('/counties', [CountiesController::class, 'store'])->middleware('auth:sanctum');
Route::patch('/counties/{id}', [CountiesController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/counties/{id}', [CountiesController::class, 'destroy'])->middleware('auth:sanctum');

Route::get('/counties/{id}/cities', [CitiesController::class, 'getCitiesByCountyId']);

Route::get('/cities', [CitiesController::class, 'index']);
Route::post('/cities', [CitiesController::class, 'store'])->middleware('auth:sanctum');
Route::patch('/cities/{id}', [CitiesController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/cities/{id}', [CitiesController::class, 'destroy'])->middleware('auth:sanctum');
