<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateNamHocRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ten_nam_hoc'   => 'required|string|min:4|max:50|unique:nam_hocs,ten_nam_hoc',
            'ngay_bat_dau'  => 'required|date',
            'ngay_ket_thuc' => 'required|date|after:ngay_bat_dau',
        ];
    }

    public function messages(): array
    {
        return [
            'ten_nam_hoc.required'   => 'Tên năm học không được để trống.',
            'ten_nam_hoc.string'      => 'Tên năm học phải là chuỗi.',
            'ten_nam_hoc.min'         => 'Tên năm học phải có ít nhất 4 ký tự.',
            'ten_nam_hoc.max'         => 'Tên năm học không được vượt quá 50 ký tự.',
            'ten_nam_hoc.unique'      => 'Tên năm học đã tồn tại trong hệ thống.',

            'ngay_bat_dau.required'  => 'Ngày bắt đầu không được để trống.',
            'ngay_bat_dau.date'      => 'Ngày bắt đầu không đúng định dạng.',

            'ngay_ket_thuc.required' => 'Ngày kết thúc không được để trống.',
            'ngay_ket_thuc.date'    => 'Ngày kết thúc không đúng định dạng.',
            'ngay_ket_thuc.after'   => 'Ngày kết thúc phải sau ngày bắt đầu.',
        ];
    }
}
