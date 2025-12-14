<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ActivateAccountMail;
use App\Mail\ResetPasswordMail;
use App\Mail\AccountActivatedMail;
use App\Mail\PasswordChangedMail;

class TestMailController extends Controller
{
    /**
     * Test gửi mail kích hoạt tài khoản
     */
    public function testActivateAccount()
    {
        $user = (object) [
            'ho_va_ten' => 'Nguyễn Văn A',
            'email' => 'test@example.com',
            'created_at' => now()
        ];

        $activationUrl = 'https://example.com/activate?token=123';

        try {
            Mail::to($user->email)->send(new ActivateAccountMail($user, $activationUrl));
            return response()->json([
                'success' => true,
                'message' => 'Mail kích hoạt tài khoản đã được gửi thành công!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi gửi mail: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test gửi mail đặt lại mật khẩu
     */
    public function testResetPassword()
    {
        $user = (object) [
            'ho_va_ten' => 'Nguyễn Văn A',
            'email' => 'test@example.com'
        ];

        $resetUrl = 'https://example.com/reset?token=123';

        try {
            Mail::to($user->email)->send(new ResetPasswordMail($user, $resetUrl));
            return response()->json([
                'success' => true,
                'message' => 'Mail đặt lại mật khẩu đã được gửi thành công!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi gửi mail: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test gửi mail thông báo kích hoạt thành công
     */
    public function testAccountActivated()
    {
        $user = (object) [
            'ho_va_ten' => 'Nguyễn Văn A',
            'email' => 'test@example.com'
        ];

        $loginUrl = 'https://example.com/login';

        try {
            Mail::to($user->email)->send(new AccountActivatedMail($user, $loginUrl));
            return response()->json([
                'success' => true,
                'message' => 'Mail thông báo kích hoạt thành công đã được gửi!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi gửi mail: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test gửi mail thông báo đổi mật khẩu thành công
     */
    public function testPasswordChanged()
    {
        $user = (object) [
            'ho_va_ten' => 'Nguyễn Văn A',
            'email' => 'test@example.com'
        ];

        $loginUrl = 'https://example.com/login';

        try {
            Mail::to($user->email)->send(new PasswordChangedMail($user, $loginUrl));
            return response()->json([
                'success' => true,
                'message' => 'Mail thông báo đổi mật khẩu thành công đã được gửi!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi gửi mail: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test preview tất cả các view mail
     */
    public function previewAllMails()
    {
        $user = (object) [
            'ho_va_ten' => 'Nguyễn Văn A',
            'email' => 'test@example.com',
            'created_at' => now()
        ];

        $activationUrl = 'https://example.com/activate?token=123';
        $resetUrl = 'https://example.com/reset?token=123';
        $loginUrl = 'https://example.com/login';

        return view('emails.preview', compact('user', 'activationUrl', 'resetUrl', 'loginUrl'));
    }
}
