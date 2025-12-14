<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBaiVietRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'tieu_de' => 'required|string|max:255|unique:bai_viets,tieu_de',
            'noi_dung' => 'required|string',
            'hinh_anh' => 'nullable|string',
            'ngay_dang' => 'nullable|date',
            'tinh_trang' => 'nullable|boolean',
            'id_loai_bai_viet' => 'required|exists:loai_bai_viets,id',
        ];
    }

    public function messages(): array
    {
        return [
            'tieu_de.required' => 'Tiêu đề không được để trống.',
            'tieu_de.string' => 'Tiêu đề phải là chuỗi.',
            'tieu_de.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'tieu_de.unique' => 'Tiêu đề này đã tồn tại trong hệ thống.',

            'noi_dung.required' => 'Nội dung không được để trống.',
            'noi_dung.string' => 'Nội dung phải là chuỗi.',

            'hinh_anh.string' => 'Hình ảnh phải là chuỗi đường dẫn hợp lệ.',

            'ngay_dang.date' => 'Ngày đăng phải là định dạng ngày hợp lệ.',

            'tinh_trang.boolean' => 'Trạng thái phải là boolean (true/false).',

            'id_loai_bai_viet.required' => 'Loại bài viết không được để trống.',
            'id_loai_bai_viet.exists' => 'Loại bài viết không tồn tại trong hệ thống.',
        ];
    }
}
