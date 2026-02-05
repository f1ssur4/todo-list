<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	return view('welcome');
})->name('home');

Route::middleware('guest')->group(function () {
	Route::get('register', [RegisterController::class, 'create'])->name('register');
	Route::post('register', [RegisterController::class, 'store']);

	Route::get('login', [LoginController::class, 'create'])->name('login');
	Route::post('login', [LoginController::class, 'store']);
});

Route::middleware('auth')->group(function () {
	Route::post('logout', LogoutController::class)->name('logout');

	Route::get('dashboard', DashboardController::class)->name('dashboard');

	Route::resource('tasks', TaskController::class);
	Route::patch('tasks/{task}/toggle-status', [TaskController::class, 'toggleStatus'])
		->name('tasks.toggle-status');
	Route::post('tasks/{id}/restore', [TaskController::class, 'restore'])
		->name('tasks.restore')
		->withTrashed();

	Route::resource('categories', CategoryController::class)->except(['show']);
});
