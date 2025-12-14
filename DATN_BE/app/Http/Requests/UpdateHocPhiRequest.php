<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHocPhiRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'id' => 'required|exists:hoc_phis,id',
            'ten_loai_phi' => 'required|string|max:255',
            'don_gia' => 'required|numeric|min:0',
            'don_vi_tinh' => 'required|string|max:50',
            'ap_dung_tu_ngay' => 'required|date',
            'ap_dung_den_ngay' => 'required|date|after_or_equal:ap_dung_tu_ngay',
            'mo_ta' => 'nullable|string',
            'tinh_trang' => 'nullable|integer|in:0,1',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'ID loại phí không được để trống.',
            'id.exists' => 'Loại phí không tồn tại hoặc đã bị xóa.',

            'ten_loai_phi.required' => 'Tên loại phí không được để trống.',
            'ten_loai_phi.string' => 'Tên loại phí phải là chuỗi.',
            'ten_loai_phi.max' => 'Tên loại phí không được vượt quá 255 ký tự.',

            'don_gia.required' => 'Đơn giá không được để trống.',
            'don_gia.numeric' => 'Đơn giá phải là số.',
            'don_gia.min' => 'Đơn giá phải lớn hơn hoặc bằng 0.',

            'don_vi_tinh.required' => 'Đơn vị tính không được để trống.',
            'don_vi_tinh.string' => 'Đơn vị tính phải là chuỗi.',
            'don_vi_tinh.max' => 'Đơn vị tính không được vượt quá 50 ký tự.',

            'ap_dung_tu_ngay.required' => 'Ngày áp dụng từ không được để trống.',
            'ap_dung_tu_ngay.date' => 'Ngày áp dụng từ phải là định dạng ngày hợp lệ.',

            'ap_dung_den_ngay.required' => 'Ngày áp dụng đến không được để trống.',
            'ap_dung_den_ngay.date' => 'Ngày áp dụng đến phải là định dạng ngày hợp lệ.',
            'ap_dung_den_ngay.after_or_equal' => 'Ngày áp dụng đến phải sau hoặc bằng ngày áp dụng từ.',

            'mo_ta.string' => 'Mô tả phải là chuỗi.',

            'tinh_trang.integer' => 'Trạng thái phải là số nguyên.',
            'tinh_trang.in' => 'Trạng thái không hợp lệ. (0: Không hoạt động, 1: Hoạt động)',
        ];
    }
}
