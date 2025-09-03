<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MarketerController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;





Route::get('/', function () {
    return view('welcome');
});


// 🔹 Authentication
Route::get('/register', [RegistrationController::class, 'create'])->name('register');
Route::post('/register', [RegistrationController::class, 'store'])->name('register.store');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// Protected routes (require login)
Route::middleware('auth')->group(function () {

    // Admin Dashboard
    Route::get('/dashboard/admin', [AdminDashboardController::class, 'admin'])->name('dashboard.admin')->middleware('role:admin');

    // Marketer Dashboard
    Route::get('/dashboard/marketer', [DashboardController::class, 'marketer'])->name('dashboard.marketer') ->middleware('role:marketer');

    // Buyer/User Dashboard
    Route::get('/dashboard/user', [DashboardController::class, 'buyer'])->name('dashboard.user')->middleware('role:user');


Route::get('/marketers', [MarketerController::class, 'index'])->name('marketer.index');
Route::get('/marketers/{id}', [MarketerController::class, 'show'])->name('marketer.show');

});


// ✅ Only authenticated marketers (and admin) can manage products
Route::middleware(['auth'])->group(function () {
    Route::get('/marketer/products', [ProductController::class, 'index'])->name('marketer.products.index');
    Route::get('/marketer/products/create', [ProductController::class, 'create'])->name('marketer.products.create');
    Route::post('/marketer/products', [ProductController::class, 'store'])->name('marketer.products.store');
    Route::get('/marketer/products/{product}/edit', [ProductController::class, 'edit'])->name('marketer.products.edit');
    Route::put('/marketer/products/{product}', [ProductController::class, 'update'])->name('marketer.products.update');
    Route::delete('/marketer/products/{product}', [ProductController::class, 'destroy'])->name('marketer.products.destroy');
});

Route::get('/marketer/{id}', [MarketerController::class, 'showProfile'])
    ->name('marketer.profile.show');

    // Marketer profile management
Route::middleware(['auth', 'role:marketer'])->group(function () {
    Route::get('/marketer/profile/edit', [MarketerController::class, 'editProfile'])->name('marketer.profile.edit');
    Route::put('/marketer/profile/update', [MarketerController::class, 'updateProfile'])->name('marketer.profile.update');
});

Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');

Route::get('/search', [SearchController::class, 'index'])->name('search.index');


// Route::middleware(['auth', 'role:admin'])->group(function () {
//     Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');   // list all
//     Route::get('/users/{user}', [UserController::class, 'show'])->name('admin.users.show'); // view profile
//     Route::get('/users/create', [UserController::class, 'create'])->name('users.create'); // NEW
//     Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');       // NEW
//     Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy'); // delete
// });



Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/messages', [AdminDashboardController::class, 'listMessages'])->name('messages.index');
    Route::get('/messages/{id}', [AdminDashboardController::class, 'showMessage'])->name('messages.show');
    Route::patch('/messages/{id}/resolve', [AdminDashboardController::class, 'markResolved'])->name('messages.resolve');
});

Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');


Route::post('/admin/messages/{id}/reply', [MessageController::class, 'reply'])->name('admin.messages.reply');
Route::delete('/admin/messages/{id}', [MessageController::class, 'destroy'])->name('admin.messages.destroy');



// Route::get('/admin/messages/{id}', [AdminDashboardController::class, 'showMessage'])->name('admin.messages.show');
// Route::post('/admin/messages/{id}/resolve', [AdminDashboardController::class, 'markResolved'])->name('admin.messages.resolve');
