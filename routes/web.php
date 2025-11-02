<?php

use App\Http\Controllers\ChallengeAdminController;
use App\Http\Controllers\ChallengeUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

Route::prefix('challenges')->name('challenges.')->group(function () {
    Route::get('/', [ChallengeUserController::class, 'index'])->name('index');
    Route::get('/dashboard', [ChallengeUserController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/badges', [ChallengeUserController::class, 'badges'])->name('badges');
    Route::get('/leaderboard', [ChallengeUserController::class, 'leaderboard'])->name('leaderboard');

    Route::get('/{challenge}/join', [ChallengeUserController::class, 'joinForm'])->name('join');
    Route::post('/{challenge}/join', [ChallengeUserController::class, 'join'])->name('join.store');

    Route::get('/{challenge}/progress', [ChallengeUserController::class, 'progressForm'])->name('progress.create');
    Route::post('/{challenge}/progress', [ChallengeUserController::class, 'progress'])->name('progress.store');

    Route::get('/{challenge}', [ChallengeUserController::class, 'show'])->name('show');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('challenges', ChallengeAdminController::class);
});
