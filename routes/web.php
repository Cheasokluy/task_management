<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Middleware\Role;
use Illuminate\Support\Facades\Auth;

 // Home route
Route::get('/', function () {
    return view('welcome');
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// Task CRUD routes
Route::middleware('auth')->group(function () {
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create')->middleware('role:admin');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store')->middleware('role:admin');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit')->middleware('role:admin');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update')->middleware('role:admin');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy')->middleware('role:admin');
    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
});

// Admin CRUD routes for user
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'userList'])->name('userList');
    Route::get('/users/create', [AdminController::class, 'create'])->name('create');
    Route::post('/users', [AdminController::class, 'store'])->name('store');
    Route::get('/users/{user}/edit', [AdminController::class, 'edit'])->name('edit');
    Route::put('/users/{user}', [AdminController::class, 'update'])->name('update');
    Route::delete('/users/{user}', [AdminController::class, 'destroy'])->name('destroy');
});

// User dashboard route
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
});


// Task CRUD routes use resource
// Route::resource('tasks', TaskController::class)->middleware('auth', 'role:admin');

// Task CRUD routes
// Route::middleware('auth')->group(function () {
//     Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
//     Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
//     Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
//     Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
//     Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
//     Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
// });
// Admin CRUD routes for user
// Route::middleware(['auth', 'role:admin'])->group(function () {
//     Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
//     Route::get('/admin/create', [AdminController::class, 'create'])->name('admin.create');
//     Route::post('/admin/dashboard', [AdminController::class, 'store'])->name('admin.store');
//     Route::get('/admin/{user}/edit', [AdminController::class, 'edit'])->name('admin.edit');
//     Route::put('/admin/{user}', [AdminController::class, 'update'])->name('admin.update');
//     Route::delete('/admin/{user}', [AdminController::class, 'destroy'])->name('admin.destroy');
// });

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
