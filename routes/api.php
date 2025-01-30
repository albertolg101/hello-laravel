<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::name('api.')->middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('polls', \App\Http\Controllers\Api\PollController::class);
});
