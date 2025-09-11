<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\MarketerController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// 🔹 Authentication
Route::controller(RegistrationController::class)->group(function () {
    Route::get('/register', 'create')->name('register');
    Route::post('/register', 'store')->name('register.store');
});

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login')->name('login.attempt');
    Route::post('/logout', 'logout')->name('logout');
});

// Protected routes (require login)
Route::middleware('auth')->group(function () {

    // Admin Dashboard
    Route::get('/dashboard/admin', [AdminDashboardController::class, 'admin'])->name('dashboard.admin')->middleware('role:admin');

    // Marketer Dashboard
    Route::get('/dashboard/marketer', [DashboardController::class, 'marketer'])->name('dashboard.marketer')->middleware('role:marketer');

    // Buyer/User Dashboard
    Route::get('/dashboard/user', [DashboardController::class, 'buyer'])->name('dashboard.user')->middleware('role:user');

    Route::get('/marketers', [MarketerController::class, 'index'])->name('marketer.index');
    Route::get('/marketers/{id}', [MarketerController::class, 'show'])->name('marketer.show');
});


// ✅ Only authenticated marketers (and admin) can manage products
Route::middleware('auth')->prefix('marketer/products')->name('marketer.products.')->controller(ProductController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/', 'store')->name('store');
    Route::get('/{product}/edit', 'edit')->name('edit');
    Route::put('/{product}', 'update')->name('update');
    Route::delete('/{product}', 'destroy')->name('destroy');
});

Route::get('/marketer/{id}', [MarketerController::class, 'showProfile'])
    ->name('marketer.profile.show');

// Marketer profile management
Route::middleware(['auth', 'role:marketer'])->prefix('marketer/profile')->name('marketer.profile.')->controller(MarketerController::class)->group(function () {
    Route::get('/edit', 'editProfile')->name('edit');
    Route::put('/update', 'updateProfile')->name('update');
});

Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');

Route::get('/search', [SearchController::class, 'index'])->name('search.index');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Users
    Route::controller(UserController::class)->prefix('users')->name('users.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{user}', 'show')->name('show');
        Route::get('/{user}/edit', 'edit')->name('edit');
        Route::put('/{user}', 'update')->name('update');
        Route::delete('/{user}', 'destroy')->name('destroy');
    });

    // Messages
    Route::controller(AdminDashboardController::class)->prefix('messages')->name('messages.')->group(function () {
        Route::get('/', 'listMessages')->name('index');
        Route::get('/{id}', 'showMessage')->name('show');
        Route::patch('/{id}/resolve', 'markResolved')->name('resolve');
    });

    Route::controller(MessageController::class)->prefix('messages')->name('messages.')->group(function () {
        Route::post('/{id}/reply', 'reply')->name('reply');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });
});

Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');

Route::middleware(['auth'])->group(function () {
    Route::prefix('favorites')->name('favorites.')->controller(FavoriteController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/{marketer}', 'store')->name('store');
        Route::delete('/{marketer}', 'destroy')->name('destroy');
    });
});
