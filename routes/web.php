<?php

use App\Http\Controllers\IssueController;
use App\Http\Controllers\PublicIssueController;
use App\Http\Controllers\Admin\AdminIssueController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::get(
    '/dashboard',
    [DashboardController::class, 'index']
)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('issues', IssueController::class);
});

// Admin routes - protected by 'admin' middleware
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/issues', [AdminIssueController::class, 'index'])->name('issues.index');
    Route::get('/issues/{issue}', [AdminIssueController::class, 'show'])->name('issues.show');
    Route::patch('/issues/{issue}', [AdminIssueController::class, 'update'])->name('issues.update');
});

// Public route (no authentication required)
Route::get('/community-progress', [PublicIssueController::class, 'index'])->name('public.issues');

require __DIR__ . '/auth.php';
