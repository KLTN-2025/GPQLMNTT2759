<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateNhanVienRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'ho_va_ten'     => 'required|string|min:6|max:100',
            'so_dien_thoai' => 'required|digits:10',
            'avatar'        => 'nullable|string',
            'email'         => 'required|email|unique:nhan_viens,email',
            'id_chuc_vu'    => 'required|exists:chuc_vus,id',
            'gioi_tinh'     => 'required|boolean',
            'dia_chi'       => 'required|string|max:225',
            'ngay_sinh'     =>  'required|date',
            'tinh_trang'    => 'required|boolean',
        ];
    }
    public function messages(): array
    {
        return [
            'ho_va_ten.required'    => 'Họ và tên không được để trống.',
            'ho_va_ten.string'      => 'Họ và tên phải là chuỗi.',
            'ho_va_ten.min'         => 'Họ và tên phải có ít nhất 6 ký tự.',
            'ho_va_ten.max'         => 'Họ và tên không được vượt quá 100 ký tự.',

            'so_dien_thoai.required' => 'Số điện thoại không được để trống.',
            'so_dien_thoai.digits'  => 'Số điện thoại phải gồm đúng 10 chữ số.',

            'avatar.string'         => 'Avatar phải là một chuỗi đường dẫn hợp lệ.',

            'email.required'        => 'Email không được để trống.',
            'email.email'           => 'Email không đúng định dạng.',
            'email.unique'          => 'Email đã tồn tại trong hệ thống.',

            'id_chuc_vu.required'   => 'Chức vụ không được để trống.',
            'id_chuc_vu.exists'     => 'Chức vụ không hợp lệ.',

            'gioi_tinh.required'    => 'Giới tính không được để trống.',
            'gioi_tinh.boolean'     => 'Giới tính không hợp lệ. (0 là Nữ, 1 là Nam)',

            'dia_chi.required'      => 'Địa chỉ không được để trống.',
            'dia_chi.string'        => 'Địa chỉ phải là chuỗi.',
            'dia_chi.max'           => 'Địa chỉ không được vượt quá 225 ký tự.',

            'ngay_sinh.required'    => 'Ngày sinh không được để trống.',
            'ngay_sinh.date'        => 'Ngày sinh phải là định dạng ngày hợp lệ (YYYY-MM-DD).',

            'tinh_trang.required'   => 'Tình trạng không được để trống.',
            'tinh_trang.boolean'    => 'Tình trạng không hợp lệ. (1 là hoạt động, 0 là nghỉ)',
        ];
    }
}
