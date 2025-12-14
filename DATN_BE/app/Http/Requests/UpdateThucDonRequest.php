<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateThucDonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'required|exists:thuc_dons,id',
            'ten_thuc_don' => 'required|string|max:255',
            'ngay' => 'required|date',
            'mo_ta' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'ID thực đơn không được để trống.',
            'id.exists' => 'Thực đơn không tồn tại hoặc đã bị xóa.',

            'ten_thuc_don.required' => 'Tên thực đơn không được để trống.',
            'ten_thuc_don.string' => 'Tên thực đơn phải là chuỗi.',
            'ten_thuc_don.max' => 'Tên thực đơn không được vượt quá 255 ký tự.',

            'ngay.required' => 'Ngày áp dụng không được để trống.',
            'ngay.date' => 'Ngày áp dụng phải là định dạng ngày hợp lệ.',

            'mo_ta.string' => 'Mô tả phải là chuỗi.',
        ];
    }
}
