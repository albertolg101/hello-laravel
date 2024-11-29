<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\PollController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('polls', PollController::class);
