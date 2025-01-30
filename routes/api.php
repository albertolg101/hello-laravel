<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function () {
    Route::apiResource('polls', \App\Http\Controllers\Api\PollController::class);
});
