<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LinkController;


Route::view('/', 'welcome');
Route::impersonate();//it is used for logging in the user admin what directly

Route::prefix('/user')->group(function () {
    Route::view('/pixels', 'user.pixel')->name('user.pixel');
    Route::view('/spaces', 'user.space')->name('user.space');
    Route::view('/links', 'user.link')->name('user.link');
    Route::view('/domains', 'user.domain')->name('user.domain');
    });


Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::prefix('/admin')->group(function () {
            Route::view('/', 'admin.index')->name('admin.index');
            Route::view('/pixels', 'pixels')->name('pixels');
            Route::view('/spaces', 'spaces')->name('spaces');
            Route::view('/links', 'links')->name('links');
            Route::view('/domains', 'domains')->name('domains');

            //resource is used if you want to have all the routes needed in crud operation
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
