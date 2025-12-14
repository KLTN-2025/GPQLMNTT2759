<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBaiVietRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'id' => 'required|exists:bai_viets,id',
            'tieu_de' => [
                'required',
                'string',
                'max:255',
                Rule::unique('bai_viets', 'tieu_de')->ignore($this->id),
            ],
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
            'id.required' => 'ID bài viết không được để trống.',
            'id.exists' => 'Bài viết không tồn tại hoặc đã bị xóa.',

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


