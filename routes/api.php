<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\ReserveFoodController;
use App\http\Controllers\ReserveController;

Route::prefix('')->group(function () {
    
    Route::resource('users', UserController::class);
    Route::resource('foods', FoodController::class);
    Route::resource('reserve_food', ReserveFoodController::class);
    Route::resource('reserves', ReserveController::class);
    Route::get('/users-pdf', [UserController::class, 'generateUsersPDF']);
    Route::get('/reserved-foods-pdf', [ReserveFoodController::class, 'generateReservedFoodsPDF']);

});

