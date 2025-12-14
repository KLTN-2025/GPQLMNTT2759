<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateThongBaoRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'id' => 'required|exists:thong_baos,id',
            'tieu_de' => 'required|string|max:255',
            'noi_dung' => 'required|string',
            'hinh_anh' => 'nullable|string',
            'tep_dinh_kem' => 'nullable|string',
            'thoi_gian_dang' => 'nullable|date',
            'ngay_het_hieu_luc' => 'nullable|date',
            'loai_thong_bao' => 'required|integer',
            'tinh_trang' => 'nullable|integer|in:0,1,2',
            // Đối tượng nhận (recipients)
            'id_phu_huynh' => 'nullable|array',
            'id_phu_huynh.*' => 'nullable|integer|exists:phu_huynhs,id',
            'id_giao_vien' => 'nullable|array',
            'id_giao_vien.*' => 'nullable|integer|exists:giao_viens,id',
            'id_lop_hoc' => 'nullable|array',
            'id_lop_hoc.*' => 'nullable|integer|exists:lop_hocs,id',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'ID thông báo không được để trống.',
            'id.exists' => 'Thông báo không tồn tại hoặc đã bị xóa.',

            'tieu_de.required' => 'Tiêu đề không được để trống.',
            'tieu_de.string' => 'Tiêu đề phải là chuỗi.',
            'tieu_de.max' => 'Tiêu đề không được vượt quá 255 ký tự.',

            'noi_dung.required' => 'Nội dung không được để trống.',
            'noi_dung.string' => 'Nội dung phải là chuỗi.',

            'ngay_het_hieu_luc.required' => 'Ngày hết hiệu lực không được để trống.',
            'ngay_het_hieu_luc.date' => 'Ngày hết hiệu lực phải là định dạng ngày hợp lệ.',

            'loai_thong_bao.required' => 'Loại thông báo không được để trống.',
            'loai_thong_bao.integer' => 'Loại thông báo phải là số nguyên.',

            'tinh_trang.integer' => 'Trạng thái phải là số nguyên.',
            'tinh_trang.in' => 'Trạng thái không hợp lệ. (0: Không hoạt động, 1: Hoạt động)',
        ];
    }
}
