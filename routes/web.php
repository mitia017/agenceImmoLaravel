<?php

//Namespaces
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\Admin\NotificationController;

/*------------------------------------------------------------------------------------------------------------------------------------------*/
//Verification Variables
$regexId = '[0-9]+';
$regexSlug = '[0-9a-z\-]+';

/*------------------------------------------------------------------------------------------------------------------------------------------*/
//Client
Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/biens', [App\Http\Controllers\AgenceController::class, 'index'])->name('property.index');
Route::get('/biens/{slug}-{property}', [App\Http\Controllers\AgenceController::class, 'show'])->name('property.show')->where([
    'property' => $regexId,
    'slug' => $regexSlug,
]);

/*------------------------------------------------------------------------------------------------------------------------------------------*/
//Properties
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function(){
    Route::resource('property', App\Http\Controllers\Admin\PropertyController::class)->except(['show']);
    Route::resource('option', App\Http\Controllers\Admin\OptionController::class)->except(['show']);
});
Route::post('/biens/{property}/contact', [App\Http\Controllers\AgenceController::class, 'contact'])->name('property.contact')->where([
    'property' => $regexId,
]);

/*------------------------------------------------------------------------------------------------------------------------------------------*/
//Control Panel
Route::middleware(['auth'])->group(function() {
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create')->can('create', User::class);
    Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store')->can('create', User::class);
    Route::put('/admin/users/{user}/role', [UserController::class, 'updateRole'])->name('admin.users.updateRole')->can('updateRole,user');
    Route::delete('/admin/users/{user}/delete', [UserController::class, 'destroy'])->name('user.destroy');
});
//Notifications
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::delete('/notifications/{notification}/delete', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::get('/notifications/{notification}', [NotificationController::class, 'show'])->name('notifications.show');
    Route::post('/notifications/{notification}/mail', [NotificationController::class, 'sendMail'])->name('notifications.mail');

});
Route::post('/read-all', function () {
    auth()->user()->unreadNotifications->markAsRead();
    return back()->with('success', 'Toutes les notifications ont été marquées comme lues');
})->name('notifications.readAll');
//Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
//Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

/*------------------------------------------------------------------------------------------------------------------------------------------*/
//API Ressources
Route::middleware('auth')->get('/dashboard/data', [\App\Http\Controllers\Api\DashboardController::class, 'index']);

/*------------------------------------------------------------------------------------------------------------------------------------------*/
require __DIR__.'/auth.php';

/*------------------------------------------------------------------------------------------------------------------------------------------*/
