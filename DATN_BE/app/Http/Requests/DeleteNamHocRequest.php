<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteNamHocRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'required|exists:nam_hocs,id',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'ID năm học không được để trống.',
            'id.exists'   => 'Năm học không tồn tại trong hệ thống.',
        ];
    }
}
