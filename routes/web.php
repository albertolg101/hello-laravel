<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\PollController;
use App\Http\Controllers\User\PlayController;
use App\Http\Controllers\User\VoteController;

Route::get('/', [PlayController::class, 'index'])->name('play.index');
Route::post('/vote', [VoteController::class, 'store'])->name('vote.store');

Route::resource('polls', PollController::class);
