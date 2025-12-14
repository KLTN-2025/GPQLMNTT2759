<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteLopHocRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'id' => 'required|exists:lop_hocs,id',
        ];
    }
    public function messages(): array
    {
        return [
            'id.required' => 'ID lớp học không được để trống.',
            'id.exists'   => 'Lớp học không tồn tại trong hệ thống.',
        ];
    }
}
