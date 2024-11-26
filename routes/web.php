<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::name('user.')->group(function () {
    Route::get('user/polls', [\App\Http\Controllers\User\PollController::class, 'index'])->name('poll.index');
    Route::get('user/polls/{id}', [\App\Http\Controllers\User\PollController::class, 'show'])->name('poll.show');
});
