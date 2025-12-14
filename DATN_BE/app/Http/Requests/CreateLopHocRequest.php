<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateLopHocRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'ten_lop'       => 'required|string|min:2|max:50',
            'id_khoi_lop'   => 'required|exists:khoi_lops,id',
            'id_nam_hoc'    => 'required|exists:nam_hocs,id',
            'id_giao_vien'  => 'required|exists:giao_viens,id',
            'so_luong'      => 'required|integer|min:1|max:50',
        ];
    }
    public function messages(): array
    {
        return [
            'ten_lop.required'      => 'Tên lớp không được để trống.',
            'ten_lop.string'        => 'Tên lớp phải là chuỗi.',
            'ten_lop.min'           => 'Tên lớp phải có ít nhất 2 ký tự.',
            'ten_lop.max'           => 'Tên lớp không được vượt quá 50 ký tự.',

            'id_khoi_lop.required'  => 'Khối lớp không được để trống.',
            'id_khoi_lop.exists'    => 'Khối lớp không tồn tại trong hệ thống.',

            'id_nam_hoc.required'   => 'Năm học không được để trống.',
            'id_nam_hoc.exists'     => 'Năm học không tồn tại trong hệ thống.',

            'id_giao_vien.required' => 'Giáo viên không được để trống.',
            'id_giao_vien.exists'   => 'Giáo viên không tồn tại trong hệ thống.',

            'so_luong.required'     => 'Số lượng học sinh không được để trống.',
            'so_luong.integer'      => 'Số lượng học sinh phải là số nguyên.',
            'so_luong.min'          => 'Số lượng học sinh phải ít nhất là 1.',
            'so_luong.max'          => 'Số lượng học sinh không được vượt quá 50.',
        ];
    }
}
