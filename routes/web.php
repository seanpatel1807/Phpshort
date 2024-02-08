<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    
    Route::middleware(['auth', 'role:admin'])->group(function () {
        // Admin routes
        Route::prefix('/admin')->group(function () {//all the routes which comes under admin will be under this function
            Route::view('/', 'admin.index')->name('admin.index');
            Route::view('/pixels', 'pixels')->name('pixels');
            Route::view('/spaces', 'spaces')->name('spaces');
            Route::view('/links', 'links')->name('links');
            Route::view('/domains', 'domains')->name('domains');
            
            Route::get('/users', [UserController::class, 'Index'])->name('users.index');
            Route::get('/users/edit/{user}', [UserController::class, 'edit'])->name('user.edit');
            Route::patch('/users/update/{user}', [UserController::class, 'update'])->name('user.update');
            Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

            Route::get('/pages', [PageController::class, 'Index'])->name('page.index');
            Route::get('pages/create', [PageController::class, 'create'])->name('pages.create');
            Route::post('pages/store', [PageController::class, 'store'])->name('pages.store');
            Route::get('/pages/edit/{user}', [PageController::class, 'edit'])->name('pages.edit');
            Route::patch('/pages/update/{user}', [PageController::class, 'update'])->name('pages.update');
            Route::delete('/pages/{user}', [PageController::class, 'destroy'])->name('pages.destroy');

            Route::prefix('/general')->group(function () {//same another function for another prefixs
                Route::get('/', [IndexController::class, 'setting'])->name('admin.setting');
                Route::post('/update', [IndexController::class,'updateSettings'])->name('admin.general.update');
            });

            Route::prefix('/appearance')->group(function () {
                Route::get('/', [IndexController::class, 'appearance'])->name('admin.appearance');
                Route::post('/update', [IndexController::class,'updateappearance'])->name('admin.appearance.update');
            });

            Route::prefix('/social')->group(function () {
                Route::get('/', [IndexController::class, 'social'])->name('admin.social');
                Route::post('/update', [IndexController::class,'updatesocial'])->name('admin.social.update');
            });

            Route::prefix('/announcement')->group(function () {
                Route::get('/', [IndexController::class, 'announcement'])->name('admin.announcement');
                Route::post('/update', [IndexController::class,'updateannouncement'])->name('admin.announcement.update');
            });
        });
    });

    Route::middleware('auth')->group(function () {
        // Profile routes
        Route::prefix('/profile')->group(function () {
            Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
        });
    });
});

require __DIR__.'/auth.php';
?>
