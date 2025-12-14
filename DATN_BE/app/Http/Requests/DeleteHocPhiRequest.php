<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteHocPhiRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'id' => 'required|exists:hoc_phis,id',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'ID loại phí không được để trống.',
            'id.exists' => 'Loại phí không tồn tại hoặc đã bị xóa.',
        ];
    }
}
