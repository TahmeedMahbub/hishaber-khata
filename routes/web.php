<?php

use App\Domains\Auth\Controllers\LoginController;
use App\Domains\Auth\Controllers\RegisterController;
use App\Domains\Category\Controllers\CategoryController;
use App\Domains\Common\Controllers\FeedbackController;
use App\Domains\Customer\Controllers\CustomerController;
use App\Domains\Dashboard\Controllers\DashboardController;
use App\Domains\Expense\Controllers\ExpenseController;
use App\Domains\Inventory\Controllers\DamageController;
use App\Domains\Notification\Controllers\NotificationController;
use App\Domains\Payment\Controllers\DuePaymentController;
use App\Domains\Product\Controllers\ProductController;
use App\Domains\Purchase\Controllers\PurchaseController;
use App\Domains\Purchase\Controllers\PurchaseReturnController;
use App\Domains\Report\Controllers\ReportController;
use App\Domains\Sales\Controllers\SaleController;
use App\Domains\Sales\Controllers\SaleReturnController;
use App\Domains\Supplier\Controllers\SupplierController;
use App\Domains\Tenant\Controllers\SettingsController;
use App\Support\LandingSeo;
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
    return view('landing', [
        'seo' => LandingSeo::make(request(), 'bn'),
    ]);
})->name('home');

Route::get('/{locale}', function (string $locale) {
    return view('landing', [
        'seo' => LandingSeo::make(request(), $locale),
    ]);
})->whereIn('locale', ['bn', 'en'])->name('landing.locale');

Route::get('/sitemap.xml', function () {
    return response()
        ->view('sitemap', ['urls' => LandingSeo::sitemap(request())])
        ->header('Content-Type', 'application/xml');
})->name('sitemap');

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

    // Password reset (forgot password) — available to all users by email.
    Route::get('/forgot-password', [\App\Domains\Auth\Controllers\PasswordResetController::class, 'request'])
        ->name('password.request');
    Route::post('/forgot-password', [\App\Domains\Auth\Controllers\PasswordResetController::class, 'email'])
        ->middleware('throttle:6,1')
        ->name('password.email');
    Route::get('/reset-password/{token}', [\App\Domains\Auth\Controllers\PasswordResetController::class, 'reset'])
        ->name('password.reset');
    Route::post('/reset-password', [\App\Domains\Auth\Controllers\PasswordResetController::class, 'update'])
        ->middleware('throttle:6,1')
        ->name('password.update');
});

/*
| Email verification (Brevo) — owner must be authenticated but not yet verified
*/
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', [\App\Domains\Auth\Controllers\VerifyEmailController::class, 'notice'])
        ->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', [\App\Domains\Auth\Controllers\VerifyEmailController::class, 'verify'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('/email/verify-code', [\App\Domains\Auth\Controllers\VerifyEmailController::class, 'verifyCode'])
        ->middleware('throttle:6,1')
        ->name('verification.code');

    Route::post('/email/verification-notification', [\App\Domains\Auth\Controllers\VerifyEmailController::class, 'resend'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});

/*
| Employee invitation setup — opened from the email link (signed, no auth)
*/
Route::middleware('signed')->group(function () {
    Route::get('/employee/setup/{id}/{hash}', [\App\Domains\Auth\Controllers\EmployeeSetupController::class, 'show'])
        ->name('employee.setup');

    Route::post('/employee/setup/{id}/{hash}', [\App\Domains\Auth\Controllers\EmployeeSetupController::class, 'store'])
        ->name('employee.setup.store');
});

/*
| Authenticated + tenant-scoped routes
*/
Route::middleware(['auth', 'verified.owner', 'tenant'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/dashboard/stats', [DashboardController::class, 'stats'])->name('dashboard.stats');
    Route::get('/dashboard/alerts', [DashboardController::class, 'alerts'])->name('dashboard.alerts');
    Route::get('/dashboard/recent-sales', [DashboardController::class, 'recentSales'])->name('dashboard.recent-sales');
    Route::get('/dashboard/top-products', [DashboardController::class, 'topProducts'])->name('dashboard.top-products');

    Route::post('/categories/quick', [CategoryController::class, 'quickStore'])->name('categories.quickStore');
    Route::resource('categories', CategoryController::class)->except('show');
    Route::post('/products/quick', [ProductController::class, 'quickStore'])->name('products.quickStore');
    Route::get('/products/import/template', [ProductController::class, 'template'])->name('products.import.template');
    Route::post('/products/import', [ProductController::class, 'import'])->name('products.import');
    Route::patch('/products/{product}/deactivate', [ProductController::class, 'deactivate'])->name('products.deactivate');
    Route::resource('products', ProductController::class)->except('show');
    Route::resource('sales', SaleController::class)->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);
    Route::get('/sale-returns', [SaleReturnController::class, 'index'])->name('sale-returns.index');
    Route::get('/sales/{sale}/return', [SaleReturnController::class, 'create'])->name('sale-returns.create');
    Route::post('/sales/{sale}/return', [SaleReturnController::class, 'store'])->name('sale-returns.store');
    Route::get('/sale-returns/{saleReturn}', [SaleReturnController::class, 'show'])->name('sale-returns.show');
    Route::delete('/sale-returns/{saleReturn}', [SaleReturnController::class, 'destroy'])->name('sale-returns.destroy');
    Route::resource('purchases', PurchaseController::class)->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);
    Route::get('/purchase-returns', [PurchaseReturnController::class, 'index'])->name('purchase-returns.index');
    Route::get('/purchases/{purchase}/return', [PurchaseReturnController::class, 'create'])->name('purchase-returns.create');
    Route::post('/purchases/{purchase}/return', [PurchaseReturnController::class, 'store'])->name('purchase-returns.store');
    Route::get('/purchase-returns/{purchaseReturn}', [PurchaseReturnController::class, 'show'])->name('purchase-returns.show');
    Route::delete('/purchase-returns/{purchaseReturn}', [PurchaseReturnController::class, 'destroy'])->name('purchase-returns.destroy');

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

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.readAll');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('notifications.read');

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

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile');
    Route::put('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password');
    Route::put('/settings/preferences', [SettingsController::class, 'updatePreferences'])->name('settings.preferences');
    Route::get('/employees', [SettingsController::class, 'employees'])->name('employees.index');
    Route::post('/settings/employees', [SettingsController::class, 'storeEmployee'])->name('settings.employees.store');
    Route::put('/settings/employees/{employee}/toggle', [SettingsController::class, 'toggleEmployee'])->name('settings.employees.toggle');
    Route::put('/settings/employees/{employee}/resend', [SettingsController::class, 'resendInvite'])->name('settings.employees.resend');

    Route::get('/profile', [SettingsController::class, 'profile'])->name('profile');
    Route::post('/language/switch', [SettingsController::class, 'switchLanguage'])->name('language.switch');

    Route::get('/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/feedback/submit', [FeedbackController::class, 'store'])->name('feedback.store');
});
