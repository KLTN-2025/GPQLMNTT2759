<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteThucDonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'required|exists:thuc_dons,id',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'ID thực đơn không được để trống.',
            'id.exists' => 'Thực đơn không tồn tại hoặc đã bị xóa.',
        ];
    }
}
