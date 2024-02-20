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
    Route::post('/links/{id}', [LinkController::class, 'update'])->name('link.update');
    Route::delete('/delete-link/{id}', [LinkController::class, 'delete'])->name('delete.link');
    Route::get('/pixels', [PixelController::class, 'index'])->name('user.pixel');
    Route::get('/pixels/create', [PixelController::class, 'create'])->name('pixel.create');
    Route::post('/pixels', [PixelController::class, 'store'])->name('pixel.store');
    Route::delete('/pixels/{id}', [PixelController::class, 'destroy'])->name('pixels.destroy');
    Route::get('/pixels/{id}/edit', [PixelController::class, 'edit'])->name('pixels.edit');
Route::patch('/pixels/{id}', [PixelController::class, 'update'])->name('pixels.update');
    Route::view('/domains', 'user.domain')->name('user.domain'); 
    
    Route::get('/spaces', [SpaceController::class, 'showSpaces'])->name('user.space');
    Route::post('/store', [SpaceController::class, 'store'])->name('store');
    Route::get('/create', [SpaceController::class, 'create'])->name('create');
    Route::get('/spaces/{id}/edit', [SpaceController::class, 'edit'])->name('spaces.edit');
    Route::post('/spaces/{id}', [SpaceController::class, 'update'])->name('spaces.update');
    Route::delete('/spaces/{id}', [SpaceController::class, 'delete'])->name('spaces.delete');
    

});

// Authenticated User Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    // Admin Routes
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::prefix('/admin')->group(function () {
            Route::view('/', 'admin.index')->name('admin.index');
            Route::view('/pixels', 'pixels')->name('pixels');
            Route::get('/spaces', [SpaceController::class, 'data'])->name('spaces');
            Route::view('/domains', 'domains')->name('domains');
            Route::resource('users', UserController::class);
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
