<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware(['auth', 'verified'])->group(function () {//this middleware is used to store the values which are of same functionalitites
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    
    Route::middleware(['auth', 'role:admin'])->group(function () {//this middleware is used for listing all the admin roles
        Route::view('/admin', 'admin.index')->name('admin.index');
        Route::view('/pixels', 'pixels')->name('pixels');//route::view because we just have to display that page 
        Route::view('/spaces', 'spaces')->name('spaces');
        Route::view('/links', 'links')->name('links');
        Route::view('/domains', 'domains')->name('domains');
        
        Route::get('/admin/general', [IndexController::class, 'setting'])->name('admin.setting');
        Route::post('/admin/general/update', [IndexController::class,'updateSettings'])->name('admin.general.update');

        Route::get('/admin/appearance', [IndexController::class, 'appearance'])->name('admin.appearance');
        Route::post('/admin/appearance/update', [IndexController::class,'updateappearance'])->name('admin.appearance.update');

        Route::get('/admin/social', [IndexController::class, 'social'])->name('admin.social');
        Route::post('/admin/social/update', [IndexController::class,'updatesocial'])->name('admin.social.update');

        Route::get('/admin/announcement', [IndexController::class, 'announcement'])->name('admin.announcement');
        Route::post('/admin/announcement/update', [IndexController::class,'updateannouncement'])->name('admin.announcement.update');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

require __DIR__.'/auth.php';
?>