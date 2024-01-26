<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admin', function () {
    return view('admin.index');
})->middleware(['auth', 'role:admin'])->name('admin.index');

Route::get('/user', function () {
    return view('user.user');
})->middleware(['auth', 'role:user'])->name('user.user');

Route::get('/pixels', function () {
    return view('pixels');
})->middleware(['auth', 'role:admin'])->name('pixels');

Route::get('/spaces', function () {
    return view('spaces');
})->middleware(['auth', 'role:admin'])->name('spaces');

Route::get('/links', function () {
    return view('links');
})->middleware(['auth', 'role:admin'])->name('links');

Route::get('/domians', function () {
    return view('domains');
})->middleware(['auth', 'role:admin'])->name('domains');

Route::get('/admin/settings', [IndexController::class, 'setting'])->name('admin.settings');


Route::get('/domains', [Settingcontroller::class, 'showDomains']);
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';
