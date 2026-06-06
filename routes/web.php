<?php

use App\Domains\Auth\Controllers\LoginController;
use App\Domains\Auth\Controllers\RegisterController;
use App\Domains\Category\Controllers\CategoryController;
use App\Domains\Customer\Controllers\CustomerController;
use App\Domains\Dashboard\Controllers\DashboardController;
use App\Domains\Expense\Controllers\ExpenseController;
use App\Domains\Inventory\Controllers\DamageController;
use App\Domains\Product\Controllers\ProductController;
use App\Domains\Purchase\Controllers\PurchaseController;
use App\Domains\Sales\Controllers\SaleController;
use App\Domains\Supplier\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

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
    return view('landing');
})->name('home');

/*
| Guest routes: business registration & login
*/
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);

    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

/*
| Authenticated + tenant-scoped routes
*/
Route::middleware(['auth', 'tenant'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('categories', CategoryController::class)->except('show');
    Route::resource('products', ProductController::class)->except('show');
    Route::resource('sales', SaleController::class)->only(['index', 'create', 'store', 'show', 'destroy']);
    Route::resource('purchases', PurchaseController::class)->only(['index', 'create', 'store', 'show', 'destroy']);

    Route::post('/customers/quick', [CustomerController::class, 'quickStore'])->name('customers.quickStore');
    Route::resource('customers', CustomerController::class)->except('show');
    Route::resource('suppliers', SupplierController::class)->except('show');
    Route::resource('expenses', ExpenseController::class)->except('show');
    Route::resource('damages', DamageController::class)->only(['index', 'create', 'store', 'destroy']);

    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});
