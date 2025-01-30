<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\PollController;
use App\Http\Controllers\User\PlayController;
use App\Http\Controllers\User\VoteController;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::redirect('dashboard', 'user.articles.index')->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/', [PlayController::class, 'index'])->name('play.index');
Route::middleware('auth')->group(function () {
    Route::post('/vote', [VoteController::class, 'store'])->name('vote.store');
    Route::resource('polls', PollController::class);
});

