<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::put('/user/create', [UserController::class, 'create'])
    ->middleware('user.exists');

Route::post('/user/auth', [UserController::class, 'auth']);