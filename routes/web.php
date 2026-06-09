<?php

use App\Domains\Auth\Controllers\LoginController;
use App\Domains\Auth\Controllers\RegisterController;
use App\Domains\Category\Controllers\CategoryController;
use App\Domains\Common\Controllers\FeedbackController;
use App\Domains\Customer\Controllers\CustomerController;
use App\Domains\Dashboard\Controllers\DashboardController;
use App\Domains\Expense\Controllers\ExpenseController;
use App\Domains\Inventory\Controllers\DamageController;
use App\Domains\Payment\Controllers\DuePaymentController;
use App\Domains\Product\Controllers\ProductController;
use App\Domains\Purchase\Controllers\PurchaseController;
use App\Domains\Report\Controllers\ReportController;
use App\Domains\Sales\Controllers\SaleController;
use App\Domains\Supplier\Controllers\SupplierController;
use App\Domains\Tenant\Controllers\SettingsController;
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

// Public feedback (e.g. from the landing page) — no auth/tenant required.
Route::post('/feedback', [FeedbackController::class, 'storePublic'])->name('feedback.public');

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

    Route::get('/dashboard/stats', [DashboardController::class, 'stats'])->name('dashboard.stats');
    Route::get('/dashboard/alerts', [DashboardController::class, 'alerts'])->name('dashboard.alerts');
    Route::get('/dashboard/recent-sales', [DashboardController::class, 'recentSales'])->name('dashboard.recent-sales');
    Route::get('/dashboard/top-products', [DashboardController::class, 'topProducts'])->name('dashboard.top-products');

    Route::resource('categories', CategoryController::class)->except('show');
    Route::post('/products/quick', [ProductController::class, 'quickStore'])->name('products.quickStore');
    Route::get('/products/import/template', [ProductController::class, 'template'])->name('products.import.template');
    Route::post('/products/import', [ProductController::class, 'import'])->name('products.import');
    Route::resource('products', ProductController::class)->except('show');
    Route::resource('sales', SaleController::class)->only(['index', 'create', 'store', 'show', 'destroy']);
    Route::resource('purchases', PurchaseController::class)->only(['index', 'create', 'store', 'show', 'destroy']);

    Route::post('/customers/quick', [CustomerController::class, 'quickStore'])->name('customers.quickStore');
    Route::resource('customers', CustomerController::class)->except('show');
    Route::post('/suppliers/quick', [SupplierController::class, 'quickStore'])->name('suppliers.quickStore');
    Route::resource('suppliers', SupplierController::class)->except('show');

    Route::get('/due-payments/history', [DuePaymentController::class, 'history'])->name('due-payments.history');
    Route::resource('due-payments', DuePaymentController::class)
        ->only(['index', 'create', 'store', 'destroy'])
        ->parameters(['due-payments' => 'duePayment']);

    Route::resource('expenses', ExpenseController::class)->except('show');
    Route::resource('damages', DamageController::class)->only(['index', 'create', 'store', 'destroy']);

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/daily-sales', [ReportController::class, 'dailySales'])->name('daily-sales');
        Route::get('/monthly-sales', [ReportController::class, 'monthlySales'])->name('monthly-sales');
        Route::get('/purchases', [ReportController::class, 'purchases'])->name('purchases');
        Route::get('/stock', [ReportController::class, 'stock'])->name('stock');
        Route::get('/low-stock', [ReportController::class, 'lowStock'])->name('low-stock');
        Route::get('/customer-due', [ReportController::class, 'customerDue'])->name('customer-due');
        Route::get('/supplier-due', [ReportController::class, 'supplierDue'])->name('supplier-due');
        Route::get('/expenses', [ReportController::class, 'expenses'])->name('expenses');
        Route::get('/cash-book', [ReportController::class, 'cashBook'])->name('cash-book');
        Route::get('/profit-loss', [ReportController::class, 'profitLoss'])->name('profit-loss');
    });

    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile');
    Route::put('/settings/business', [SettingsController::class, 'updateBusiness'])->name('settings.business');
    Route::put('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password');

    Route::get('/profile', [SettingsController::class, 'profile'])->name('profile');

    Route::get('/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/feedback/submit', [FeedbackController::class, 'store'])->name('feedback.store');
});
