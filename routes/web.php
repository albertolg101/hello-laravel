<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\PollController;

Route::get('/', function () {
    return view('welcome');
});

Route::name('user.')->group(function () {
    Route::get('user/polls', [PollController::class, 'index'])->name('poll.index');
    Route::get('user/polls/{id}', [PollController::class, 'show'])->name('poll.show');
    Route::delete('user/polls/{id}', [PollController::class, 'destroy'])->name('poll.destroy');
});
