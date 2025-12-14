<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteHocSinhRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'id' => 'required|exists:hoc_sinhs,id',
        ];
    }
    public function messages(): array
    {
        return [
            'id.required' => 'ID học sinh không được để trống.',
            'id.exists'   => 'Học sinh không tồn tại trong hệ thống.',
        ];
    }
}
