<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\SpaceController;
use App\Http\Controllers\PixelController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::view('/', 'welcome');

// Impersonation
Route::impersonate();

// User Routes
Route::prefix('/user')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/links', [LinkController::class, 'index'])->name('user.link');
    Route::get('/links/{id}/edit', [LinkController::class, 'edit'])->name('link.edit');
    Route::patch('/links/{id}', [LinkController::class, 'update'])->name('link.update');
    Route::delete('/delete-link/{id}', [LinkController::class, 'delete'])->name('delete.link');
    Route::delete('/pixels/{id}', [PixelController::class, 'destroy'])->name('pixels.destroy');
    Route::get('/pixels/{id}/edit', [PixelController::class, 'edit'])->name('pixels.edit');
    Route::patch('/pixels/{id}', [PixelController::class, 'update'])->name('pixels.update');
    Route::resource('pixels', PixelController::class)->only(['index','create','store'])->names([
        'index' => 'user.pixel',
    'create' => 'pixel.create',
    'store'=>'pixel.store',
    ]);
    
    Route::view('/domains', 'user.domain')->name('user.domain'); 
    
    Route::resource('spaces', SpaceController::class)->except(['show'])->names([
        'create' => 'create',
        'store' => 'store',
        'edit' => 'spaces.edit',
        'destroy' =>'spaces.delete',
        'index'=>'user.space',
    ]);
    Route::post('/spaces/{id}', [SpaceController::class, 'update'])->name('spaces.update');

    
});

// Authenticated User Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    // Admin Routes
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::prefix('/admin')->group(function () {
            Route::view('/', 'admin.index')->name('admin.index');
            Route::get('/pixels', [PixelController::class, 'data'])->name('pixels');
            Route::get('/spaces', [SpaceController::class, 'data'])->name('spaces');
            Route::view('/domains', 'domains')->name('domains');
            Route::resource('users', UserController::class);
            Route::post('/users/{user}/disable', [UserController::class, 'disable'])->name('users.disable');
            Route::post('/users/{user}/enable', [UserController::class, 'enable'])->name('users.enable');
            Route::resource('pages', PageController::class);
           
            $adminRoutes = ['general', 'appearance', 'social', 'announcement','advanced'];
            foreach ($adminRoutes as $route) {
                Route::prefix("/$route")->group(function () use ($route) {
                    Route::get('/', [IndexController::class, $route])->name("admin.$route");
                    Route::post('/update', [IndexController::class, "update$route"])->name("admin.$route.update");
                });
            }
            Route::get('/links', [DataController::class, 'data'])->name('links');
            Route::get('/{shortUrl}', [DataController::class, 'redirect']);
        });
    });

    // Authenticated User Routes
    Route::prefix('/profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

// Authentication Routes
require __DIR__.'/auth.php';

// Public Link Routes
Route::post('/create-link', [LinkController::class, 'create']);
Route::get('/{shortUrl}', [LinkController::class, 'redirect']);
Route::post('/check-password/{shortUrl}', [LinkController::class,'checkPassword'])->name('check-password');
