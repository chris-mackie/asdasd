<?php

use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

Route::post('send-message', [MessageController::class, 'index'])->middleware('web');
