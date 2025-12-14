<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHocSinhRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'id'            => 'required|exists:hoc_sinhs,id',
            'ho_va_ten'     => 'required|string|min:6|max:100',
            'gioi_tinh'     => 'required|boolean',
            'avatar'        => 'nullable|string',
            'ngay_sinh'     => 'required|date',
            'dia_chi'       => 'required|string|max:225',
            'tinh_trang'    => 'required|integer|in:0,1,2',
            'id_lop_hoc'    => 'required|exists:lop_hocs,id',
            'id_phu_huynh'  => 'required|exists:phu_huynhs,id',
        ];
    }
    public function messages(): array
    {
        return [
            'id.required'           => 'ID học sinh không được để trống.',
            'id.exists'             => 'Học sinh không tồn tại trong hệ thống.',

            'ho_va_ten.required'    => 'Họ và tên không được để trống.',
            'ho_va_ten.string'      => 'Họ và tên phải là chuỗi.',
            'ho_va_ten.min'         => 'Họ và tên phải có ít nhất 6 ký tự.',
            'ho_va_ten.max'         => 'Họ và tên không được vượt quá 100 ký tự.',

            'gioi_tinh.required'    => 'Giới tính không được để trống.',
            'gioi_tinh.boolean'     => 'Giới tính không hợp lệ. (0 là Nữ, 1 là Nam)',

            'avatar.string'         => 'Avatar phải là một chuỗi đường dẫn hợp lệ.',

            'ngay_sinh.required'    => 'Ngày sinh không được để trống.',
            'ngay_sinh.date'        => 'Ngày sinh phải là định dạng ngày hợp lệ (YYYY-MM-DD).',

            'dia_chi.required'      => 'Địa chỉ không được để trống.',
            'dia_chi.string'        => 'Địa chỉ phải là chuỗi.',
            'dia_chi.max'           => 'Địa chỉ không được vượt quá 225 ký tự.',

            'tinh_trang.required'   => 'Tình trạng không được để trống.',
            'tinh_trang.integer'    => 'Tình trạng phải là số nguyên.',
            'tinh_trang.in'         => 'Tình trạng không hợp lệ. (0: Không hoạt động, 1: Hoạt động, 2: Vắng mặt)',

            'id_lop_hoc.required'   => 'Lớp học không được để trống.',
            'id_lop_hoc.exists'     => 'Lớp học không tồn tại trong hệ thống.',

            'id_phu_huynh.required' => 'Phụ huynh không được để trống.',
            'id_phu_huynh.exists'   => 'Phụ huynh không tồn tại trong hệ thống.',
        ];
    }
}
