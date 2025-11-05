<?php

use App\Http\Controllers\ChallengeAdminController;
use App\Http\Controllers\ChallengeUserController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\ReportAdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');
Route::get('/communities/dashboard', [CommunityController::class, 'dashboard'])->name('communities.dashboard');

Route::prefix('challenges')->name('challenges.')->group(function () {
    Route::get('/', [ChallengeUserController::class, 'index'])->name('index');
    Route::get('/dashboard', [ChallengeUserController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/badges', [ChallengeUserController::class, 'badges'])->name('badges');

    Route::get('/{challenge}/join', [ChallengeUserController::class, 'joinForm'])->name('join');
    Route::post('/{challenge}/join', [ChallengeUserController::class, 'join'])->name('join.store');

    Route::get('/{challenge}/progress', [ChallengeUserController::class, 'progressForm'])->name('progress.create');
    Route::post('/{challenge}/progress', [ChallengeUserController::class, 'progress'])->name('progress.store');

    Route::get('/{challenge}', [ChallengeUserController::class, 'show'])->name('show');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [ChallengeAdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/reports', [ReportAdminController::class, 'index'])->name('reports.index');
    Route::get('/reports/activities', [ReportAdminController::class, 'activities'])->name('reports.activities');
    Route::resource('challenges', ChallengeAdminController::class);
});
