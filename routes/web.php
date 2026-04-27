<?php

use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\OptionController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\AgenceController;
use App\Http\Controllers\Api\DashboardController as ApiDashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

// Client Routes
Route::get('/', [HomeController::class, 'index']);
Route::prefix('biens')->name('property.')->group(function () {
    Route::get('/', [AgenceController::class, 'index'])->name('index');
    Route::get('/{slug}-{property}', [AgenceController::class, 'show'])->name('show')
        ->where(['property' => '[0-9]+', 'slug' => '[0-9a-z\-]+']);
    Route::post('/{property}/contact', [AgenceController::class, 'contact'])->name('contact')
        ->where(['property' => '[0-9]+']);
});

// Admin & Auth Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['verified'])->name('dashboard');

    // Admin Prefix
    Route::prefix('admin')->name('admin.')->group(function () {
        // Resources
        Route::resource('property', PropertyController::class)->except(['show']);
        Route::resource('option', OptionController::class)->except(['show']);

        // Users
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create')->can('create', User::class);
        Route::post('/users', [UserController::class, 'store'])->name('users.store')->can('create', User::class);
        Route::put('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole')->can('updateRole,user');
        Route::delete('/users/{user}/delete', [UserController::class, 'destroy'])->name('user.destroy');

        // Notifications
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::get('/notifications/{notification}', [NotificationController::class, 'show'])->name('notifications.show');
        Route::delete('/notifications/{notification}/delete', [NotificationController::class, 'destroy'])->name('notifications.destroy');
        Route::post('/notifications/{notification}/mail', [NotificationController::class, 'sendMail'])->name('notifications.mail');
    });

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Miscellaneous
    Route::post('/read-all', function () {
        auth()->user()->unreadNotifications->markAsRead();

        return back()->with('success', 'Toutes les notifications ont été marquées comme lues');
    })->name('notifications.readAll');

    // API
    Route::get('/dashboard/data', [ApiDashboardController::class, 'index']);
});

require __DIR__.'/auth.php';
