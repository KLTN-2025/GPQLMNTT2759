<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestMailController;

Route::get('/', function () {
    return view('welcome');
});

// Test routes để xem preview các view mail
Route::get('/test/activate-account', function () {
    $user = (object) [
        'ho_va_ten' => 'Nguyễn Văn A',
        'email' => 'test@example.com',
        'created_at' => now()
    ];
    $activationUrl = 'https://example.com/activate?token=123';

    return view('emails.activate-account', compact('user', 'activationUrl'));
});

Route::get('/test/reset-password', function () {
    $user = (object) [
        'ho_va_ten' => 'Nguyễn Văn A',
        'email' => 'test@example.com'
    ];
    $resetUrl = 'https://example.com/reset?token=123';

    return view('emails.reset-password', compact('user', 'resetUrl'));
});

Route::get('/test/account-activated', function () {
    $user = (object) [
        'ho_va_ten' => 'Nguyễn Văn A',
        'email' => 'test@example.com'
    ];
    $loginUrl = 'https://example.com/login';

    return view('emails.account-activated', compact('user', 'loginUrl'));
});

Route::get('/test/password-changed', function () {
    $user = (object) [
        'ho_va_ten' => 'Nguyễn Văn A',
        'email' => 'test@example.com'
    ];
    $loginUrl = 'https://example.com/login';

    return view('emails.password-changed', compact('user', 'loginUrl'));
});

// Test routes để gửi mail thực tế
Route::prefix('mail')->group(function () {
    Route::get('/test-activate', [TestMailController::class, 'testActivateAccount']);
    Route::get('/test-reset', [TestMailController::class, 'testResetPassword']);
    Route::get('/test-activated', [TestMailController::class, 'testAccountActivated']);
    Route::get('/test-changed', [TestMailController::class, 'testPasswordChanged']);
    Route::get('/preview', [TestMailController::class, 'previewAllMails']);
});

