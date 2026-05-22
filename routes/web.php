<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CabinetController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Public Main Routes ---
Route::get('/', [MainController::class, 'home'])->name('home');
Route::get('/contacts', [MainController::class, 'contacts'])->name('contacts');
Route::get('/articles', [MainController::class, 'articles'])->name('articles.index');
Route::get('/articles/{slug}', [MainController::class, 'articleShow'])->name('articles.show');
Route::get('/promotions', [MainController::class, 'promotions'])->name('promotions.index');

// Store Reviews
Route::get('/reviews', [MainController::class, 'reviews'])->name('reviews.index');
Route::post('/reviews', [MainController::class, 'reviewStore'])->name('reviews.store')->middleware('auth');

// --- Catalog Routes ---
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/catalog/{slug}', [CatalogController::class, 'show'])->name('catalog.show');
Route::post('/catalog/{slug}/review', [CatalogController::class, 'reviewStore'])->name('catalog.review.store')->middleware('auth');

// --- Cart & Checkout Routes ---
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{key}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{key}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout')->middleware('auth');

// --- Authentication Routes (Guest) ---
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// --- Authentication Routes (Authenticated) ---
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// --- Personal Cabinet Routes ---
Route::middleware(['auth'])->prefix('cabinet')->name('cabinet.')->group(function () {
    Route::get('/', [CabinetController::class, 'index'])->name('index');
    Route::post('/profile', [CabinetController::class, 'updateProfile'])->name('profile.update');
    
    // Addresses
    Route::get('/addresses', [CabinetController::class, 'addresses'])->name('addresses');
    Route::post('/addresses', [CabinetController::class, 'storeAddress'])->name('addresses.store');
    Route::delete('/addresses/{id}', [CabinetController::class, 'deleteAddress'])->name('addresses.delete');
    
    // Orders
    Route::get('/orders', [CabinetController::class, 'orders'])->name('orders');
});

// --- Administration Panel Routes ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Categories CRUD
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
    Route::post('/categories', [AdminController::class, 'categoryStore'])->name('categories.store');
    Route::post('/categories/update/{id}', [AdminController::class, 'categoryUpdate'])->name('categories.update');
    Route::post('/categories/delete/{id}', [AdminController::class, 'categoryDestroy'])->name('categories.delete');
    
    // Products CRUD
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::post('/products', [AdminController::class, 'productStore'])->name('products.store');
    Route::post('/products/update/{id}', [AdminController::class, 'productUpdate'])->name('products.update');
    Route::post('/products/delete/{id}', [AdminController::class, 'productDestroy'])->name('products.delete');
    
    // Orders Management
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::post('/orders/status/{id}', [AdminController::class, 'orderUpdateStatus'])->name('orders.status');
    
    // Articles Management
    Route::get('/articles', [AdminController::class, 'articles'])->name('articles');
    Route::post('/articles', [AdminController::class, 'articleStore'])->name('articles.store');
    Route::post('/articles/update/{id}', [AdminController::class, 'articleUpdate'])->name('articles.update');
    Route::post('/articles/delete/{id}', [AdminController::class, 'articleDestroy'])->name('articles.delete');
    
    // Promotions Management
    Route::get('/promotions', [AdminController::class, 'promotions'])->name('promotions');
    Route::post('/promotions', [AdminController::class, 'promotionStore'])->name('promotions.store');
    Route::post('/promotions/update/{id}', [AdminController::class, 'promotionUpdate'])->name('promotions.update');
    Route::post('/promotions/delete/{id}', [AdminController::class, 'promotionDestroy'])->name('promotions.delete');
    
    // Review Moderation
    Route::get('/reviews', [AdminController::class, 'reviews'])->name('reviews');
    Route::post('/reviews/approve/{id}', [AdminController::class, 'reviewApprove'])->name('reviews.approve');
    Route::post('/reviews/delete/{id}', [AdminController::class, 'reviewDestroy'])->name('reviews.delete');
    
    // Contact Info Settings
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('/settings', [AdminController::class, 'settingsUpdate'])->name('settings.update');
});
