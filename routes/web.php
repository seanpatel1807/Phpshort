<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\SpaceController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');
Route::impersonate(); // Used for logging in the user admin directly

Route::prefix('/user')->group(function () {
    Route::view('/pixels', 'user.pixel')->name('user.pixel');
    Route::get('/spaces', [SpaceController::class, 'showSpaces'])->name('user.space');
    Route::post('/store-space', [SpaceController::class, 'store'])->name('storeSpace');
Route::get('/show-form', [SpaceController::class, 'showForm'])->name('showForm');
Route::get('/links', [LinkController::class, 'index'])->name('user.link');

    Route::delete('/delete-link/{id}', [LinkController::class, 'delete'])->name('delete.link');
    Route::view('/domains', 'user.domain')->name('user.domain');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::prefix('/admin')->group(function () {
            Route::view('/', 'admin.index')->name('admin.index');
            Route::view('/pixels', 'pixels')->name('pixels');
            Route::view('/spaces', 'spaces')->name('spaces');
            Route::get('/links', [DataController::class, 'data'])->name('links');
            Route::get('/{shortUrl}', [DataController::class, 'redirect']);
            Route::view('/domains', 'domains')->name('domains');
            Route::resource('users', UserController::class);
            Route::resource('pages', PageController::class);

            $adminRoutes = ['general', 'appearance', 'social', 'announcement'];
            foreach ($adminRoutes as $route) {
                Route::prefix("/$route")->group(function () use ($route) {
                    Route::get('/', [IndexController::class, $route])->name("admin.$route");
                    Route::post('/update', [IndexController::class, "update$route"])->name("admin.$route.update");
                });
            }
        });
    });

    Route::middleware('auth')->group(function () {
        Route::prefix('/profile')->group(function () {
            Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
        });
    });
});

require __DIR__.'/auth.php';

Route::post('/create-link', [LinkController::class, 'create']);
Route::get('/{shortUrl}', [LinkController::class, 'redirect']);
