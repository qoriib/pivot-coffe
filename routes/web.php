<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Customer;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

// ─── Landing Page Routes (now in Customer namespace) ──────────────────────────
Route::get('/', [Admin\AuthController::class, 'showLogin']);
Route::get('/order/table/{table}', [Customer\LandingController::class, 'home'])->name('customer.home');
Route::get('/about', [Customer\LandingController::class, 'about'])->name('customer.about');
Route::get('/contact', [Customer\LandingController::class, 'contact'])->name('customer.contact');
Route::post('/contact', [Customer\LandingController::class, 'submitContact'])->name('customer.contact.submit');

// ─── Customer Routes (no auth) ────────────────────────────────────────────────
Route::prefix('order')->name('customer.')->group(function () {

    // Status & feedback (no qr_token needed)
    Route::get('/status/{transaction_id}', [Customer\OrderController::class, 'status'])
        ->name('status');
    Route::get('/status/{transaction_id}/peek', [Customer\OrderController::class, 'statusPeek'])
        ->name('status.peek');
    Route::get('/feedback/{transaction_id}', [Customer\FeedbackController::class, 'show'])
        ->name('feedback');
    Route::post('/feedback/{transaction_id}', [Customer\FeedbackController::class, 'store'])
        ->name('feedback.store');

    // QR token based routes
    Route::prefix('{qr_token}')->group(function () {
        Route::get('/', [Customer\MenuController::class, 'index'])->name('menu');
        Route::get('/menu/{menu}', [Customer\MenuController::class, 'show'])->name('menu.detail');

        // Cart
        Route::post('/cart/add', [Customer\CartController::class, 'add'])->name('cart.add');
        Route::post('/cart/update', [Customer\CartController::class, 'update'])->name('cart.update');
        Route::post('/cart/remove', [Customer\CartController::class, 'remove'])->name('cart.remove');
        Route::post('/cart/clear', [Customer\CartController::class, 'clear'])->name('cart.clear');

        // Checkout
        Route::get('/checkout', [Customer\CheckoutController::class, 'show'])->name('checkout');
        Route::post('/checkout', [Customer\CheckoutController::class, 'store'])->name('checkout.store');

        // Order actions
        Route::post('/cancel', [Customer\OrderController::class, 'cancel'])->name('cancel');
        Route::post('/waiter', [Customer\OrderController::class, 'callWaiter'])->name('waiter');
    });
});

// ─── Midtrans Webhook (CSRF excluded in bootstrap/app.php) ───────────────────
Route::post('/payment/notification', [PaymentController::class, 'notification'])
    ->name('payment.notification');

// ─── Admin Auth Routes ────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [Admin\AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [Admin\AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [Admin\AuthController::class, 'logout'])->name('logout');

    // Forgot/Reset password routes
    Route::get('/forgot-password', [Admin\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [Admin\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [Admin\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [Admin\ResetPasswordController::class, 'reset'])->name('password.update');

    // Protected admin routes
    Route::middleware(\App\Http\Middleware\AdminAuthenticate::class)->group(function () {
        Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/notifications/peek', [Admin\DashboardController::class, 'notificationsPeek'])->name('notifications.peek');

        // Orders
        Route::get('/orders/monitor', [Admin\OrderController::class, 'monitor'])->name('orders.monitor');
        Route::get('/orders', [Admin\OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [Admin\OrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{order}/status', [Admin\OrderController::class, 'updateStatus'])->name('orders.status');
        Route::post('/orders/{order}/confirm-payment', [Admin\OrderController::class, 'confirmPayment'])->name('orders.confirm-payment');
        Route::get('/orders/{order}/print', [Admin\OrderController::class, 'print'])->name('orders.print');

        // Menus
        Route::get('/menus', [Admin\MenuController::class, 'index'])->name('menus.index');
        Route::post('/menus', [Admin\MenuController::class, 'store'])->name('menus.store');
        Route::put('/menus/{menu}', [Admin\MenuController::class, 'update'])->name('menus.update');
        Route::delete('/menus/{menu}', [Admin\MenuController::class, 'destroy'])->name('menus.destroy');
        Route::post('/menus/{menu}/toggle', [Admin\MenuController::class, 'toggle'])->name('menus.toggle');

        // Categories
        Route::get('/categories', [Admin\CategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [Admin\CategoryController::class, 'store'])->name('categories.store');
        Route::put('/categories/{category}', [Admin\CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [Admin\CategoryController::class, 'destroy'])->name('categories.destroy');

        // Tables
        Route::get('/tables', [Admin\TableController::class, 'index'])->name('tables.index');
        Route::post('/tables', [Admin\TableController::class, 'store'])->name('tables.store');
        Route::put('/tables/{table}', [Admin\TableController::class, 'update'])->name('tables.update');
        Route::delete('/tables/{table}', [Admin\TableController::class, 'destroy'])->name('tables.destroy');
        Route::get('/tables/{table}/qr', [Admin\TableController::class, 'qr'])->name('tables.qr');

        // Promos
        Route::get('/promos', [Admin\PromoController::class, 'index'])->name('promos.index');
        Route::post('/promos', [Admin\PromoController::class, 'store'])->name('promos.store');
        Route::put('/promos/{promo}', [Admin\PromoController::class, 'update'])->name('promos.update');
        Route::delete('/promos/{promo}', [Admin\PromoController::class, 'destroy'])->name('promos.destroy');

        // Feedback
        Route::get('/feedback', [Admin\FeedbackController::class, 'index'])->name('feedback.index');
        Route::delete('/feedback/{feedback}', [Admin\FeedbackController::class, 'destroy'])->name('feedback.destroy');

        // Waiter Calls
        Route::get('/waiter-calls', [Admin\WaiterCallController::class, 'index'])->name('waiter-calls.index');
        Route::post('/waiter-calls/{waiterCall}/done', [Admin\WaiterCallController::class, 'done'])->name('waiter-calls.done');

        // Users (manajemen akun admin)
        Route::get('/users', [Admin\UserController::class, 'index'])->name('users.index');
        Route::post('/users', [Admin\UserController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [Admin\UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [Admin\UserController::class, 'destroy'])->name('users.destroy');

        // Contact Messages
        Route::get('/contacts', [Admin\ContactMessageController::class, 'index'])->name('contacts.index');
        Route::delete('/contacts/{message}', [Admin\ContactMessageController::class, 'destroy'])->name('contacts.destroy');
    });
});
