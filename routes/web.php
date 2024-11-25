<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/polls', [App\Http\Controllers\PollController::class, 'index'])->name('poll.index');
Route::get('/polls/{id}', [App\Http\Controllers\PollController::class, 'show'])->name('poll.show');
