<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\PollController;

Route::get('/', function () {
    return view('welcome');
});

Route::name('user.')->group(function () {
    Route::name('poll.')->group(function () {
        Route::get('user/polls/create', [PollController::class, 'create'])->name('create');
        Route::get('user/polls', [PollController::class, 'index'])->name('index');
        Route::get('user/polls/{id}', [PollController::class, 'show'])->name('show');
        Route::post('user/polls', [PollController::class, 'store'])->name('store');
        Route::delete('user/polls/{id}', [PollController::class, 'destroy'])->name('destroy');
    });
});
