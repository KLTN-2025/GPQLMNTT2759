<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginPhuHuynhRequest extends FormRequest
{
    public function authorize(): bool
    {
        return false;
    }
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:phu_huynhs,email',
            'password' => 'required|min:6',
        ];
    }
    public function messages(): array
    {
        return [
            'email.required' => 'Email là trường bắt buộc',
            'email.email' => 'Email không hợp lệ',
            'email.exists' => 'Email không tồn tại',
            'password.required' => 'Mật khẩu là trường bắt buộc',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
        ];
    }
}
