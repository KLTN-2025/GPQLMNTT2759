<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGiaoVienRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'id'            => 'required|exists:giao_viens,id',
            'ho_va_ten'     => 'required|string|min:6|max:100',
            'so_dien_thoai' => 'required|digits:10',
            'avatar'        => 'nullable|string',
            'email'         => 'required|email|unique:giao_viens,email,' . $this->id,
            'gioi_tinh'     => 'required|boolean',
            'trinh_do'      => 'required|integer|min:0|max:3',
            'chuyen_mon'    => 'nullable|string|max:100',
            'dia_chi'       => 'required|string|max:225',
            'ngay_sinh'     => 'required|date',
            'tinh_trang'    => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required'           => 'ID giáo viên không được để trống.',
            'id.exists'             => 'Giáo viên không tồn tại trong hệ thống.',

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

            'gioi_tinh.required'    => 'Giới tính không được để trống.',
            'gioi_tinh.boolean'     => 'Giới tính không hợp lệ. (0 là Nữ, 1 là Nam)',

            'trinh_do.required'     => 'Trình độ không được để trống.',
            'trinh_do.integer'      => 'Trình độ phải là số nguyên.',
            'trinh_do.min'          => 'Trình độ không hợp lệ.',
            'trinh_do.max'          => 'Trình độ không hợp lệ.',

            'chuyen_mon.string'     => 'Chuyên môn phải là chuỗi.',
            'chuyen_mon.max'        => 'Chuyên môn không được vượt quá 100 ký tự.',

            'dia_chi.required'      => 'Địa chỉ không được để trống.',
            'dia_chi.string'        => 'Địa chỉ phải là chuỗi.',
            'dia_chi.max'           => 'Địa chỉ không được vượt quá 225 ký tự.',

            'ngay_sinh.required'    => 'Ngày sinh không được để trống.',
            'ngay_sinh.date'        => 'Ngày sinh phải là định dạng ngày hợp lệ.',

            'tinh_trang.required'   => 'Tình trạng không được để trống.',
            'tinh_trang.boolean'    => 'Tình trạng không hợp lệ. (1 là hoạt động, 0 là nghỉ)',
        ];
    }
}
