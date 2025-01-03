<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');


Route::middleware(['auth','verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/friend-request/send', [DashboardController::class, 'sendFriendRequest'])->name('friend-request.send');
    Route::post('/friend-requests/accept', [DashboardController::class, 'acceptFriendRequest'])->name('friend-requests.accept');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::match(['post', 'put'], '/profile/{userProfile?}', [ProfileController::class, 'save'])
        ->name('profile.save');
});

require __DIR__.'/auth.php';
