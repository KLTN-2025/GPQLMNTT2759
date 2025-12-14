<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePhuHuynhRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        $id = $this->input('id');
        return [
            'id'            => 'required|exists:phu_huynhs,id',
            'ho_va_ten'     => 'required|string|min:6|max:100',
            'so_dien_thoai' => 'required|digits:10',
            'avatar'        => 'nullable|string',
            'email'         => 'required|email|unique:phu_huynhs,email,' . $id . ',id',
            'nghe_nghiep'   => 'nullable|string|max:100',
            'password'      => 'nullable|string|min:6|max:50',
            'gioi_tinh'     => 'required|boolean',
            'quan_he'       => 'required|string|max:50',
            'dia_chi'       => 'required|string|max:255',
            'ngay_sinh'     => 'required|date|before:today',
            'is_block'      => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required'             => 'ID phụ huynh là bắt buộc.',
            'id.exists'               => 'Phụ huynh không tồn tại trong hệ thống.',

            'ho_va_ten.required'      => 'Vui lòng nhập họ và tên.',
            'ho_va_ten.min'           => 'Họ và tên phải có ít nhất :min ký tự.',
            'ho_va_ten.max'           => 'Họ và tên không được vượt quá :max ký tự.',

            'so_dien_thoai.required'  => 'Vui lòng nhập số điện thoại.',
            'so_dien_thoai.digits'    => 'Số điện thoại phải gồm đúng :digits chữ số.',

            'email.required'          => 'Vui lòng nhập email.',
            'email.email'             => 'Email không đúng định dạng.',
            'email.unique'            => 'Email đã tồn tại trong hệ thống.',

            'nghe_nghiep.max'         => 'Nghề nghiệp không được vượt quá :max ký tự.',

            'password.min'            => 'Mật khẩu phải có ít nhất :min ký tự.',
            'password.max'            => 'Mật khẩu không được vượt quá :max ký tự.',

            'gioi_tinh.required'      => 'Vui lòng chọn giới tính.',
            'gioi_tinh.boolean'       => 'Giới tính không hợp lệ.',

            'quan_he.required'        => 'Vui lòng nhập mối quan hệ với trẻ.',
            'quan_he.max'             => 'Mối quan hệ không được vượt quá :max ký tự.',

            'dia_chi.required'        => 'Vui lòng nhập địa chỉ.',
            'dia_chi.max'             => 'Địa chỉ không được vượt quá :max ký tự.',

            'ngay_sinh.required'      => 'Vui lòng nhập ngày sinh.',
            'ngay_sinh.date'          => 'Ngày sinh không đúng định dạng.',
            'ngay_sinh.before'        => 'Ngày sinh phải nhỏ hơn ngày hiện tại.',

            'is_block.boolean'        => 'Trạng thái khóa không hợp lệ.',
        ];
    }
}
