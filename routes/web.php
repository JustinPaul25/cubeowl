<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('posts')->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('post.index');
        Route::get('/view/{post}', [PostController::class, 'show'])->name('post.show');
        Route::patch('/{post}/update', [PostController::class, 'update'])->name('post.update');
        Route::get('/list', [PostController::class, 'list'])->name('post.list');
        Route::get('/create-post', [PostController::class, 'create'])->name('post.create');
        Route::delete('/{post}/post', [PostController::class, 'destroy'])->name('post.destroy');
        Route::post('/', [PostController::class, 'store'])->name('post.store');
    })->name('post');
});

require __DIR__.'/auth.php';
