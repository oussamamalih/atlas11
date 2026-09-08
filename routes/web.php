<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PlayerProfileController;
use App\Http\Controllers\PlayerSearchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScoutProfileController;
use App\Http\Controllers\ScoutingInterestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Player Profile Routes
    Route::prefix('player/profile')->name('player.profile.')->group(function () {
        Route::get('/', [PlayerProfileController::class, 'index'])->name('index');
        Route::get('/create', [PlayerProfileController::class, 'create'])->name('create');
        Route::post('/', [PlayerProfileController::class, 'store'])->name('store');
        Route::get('/edit', [PlayerProfileController::class, 'edit'])->name('edit');
        Route::put('/', [PlayerProfileController::class, 'update'])->name('update');
        Route::patch('/', [PlayerProfileController::class, 'update']);
    });

    Route::get('/players/{playerProfile}', [PlayerProfileController::class, 'show'])->name('player.profile.show');

    // Scout Profile Routes
    Route::prefix('scout/profile')->name('scout.profile.')->group(function () {
        Route::get('/', [ScoutProfileController::class, 'index'])->name('index');
        Route::get('/create', [ScoutProfileController::class, 'create'])->name('create');
        Route::post('/', [ScoutProfileController::class, 'store'])->name('store');
        Route::get('/edit', [ScoutProfileController::class, 'edit'])->name('edit');
        Route::put('/', [ScoutProfileController::class, 'update'])->name('update');
        Route::patch('/', [ScoutProfileController::class, 'update']);
    });

    Route::get('/scouts/{scoutProfile}', [ScoutProfileController::class, 'show'])->name('scout.profile.show');

    // Player Search (Scouts)
    Route::get('/scout/search', [PlayerSearchController::class, 'index'])->name('scout.search');

    // Scouting Interests
    Route::get('/scouting/interests', [ScoutingInterestController::class, 'index'])->name('scouting.interests.index');
    Route::post('/players/{playerProfile}/express-interest', [ScoutingInterestController::class, 'store'])->name('scouting.interests.store');
    Route::get('/scouting/interests/{scoutingInterest}', [ScoutingInterestController::class, 'show'])->name('scouting.interests.show');
    Route::patch('/scouting/interests/{scoutingInterest}', [ScoutingInterestController::class, 'update'])->name('scouting.interests.update');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    // Administration
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
        Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    });
});

require __DIR__.'/auth.php';
