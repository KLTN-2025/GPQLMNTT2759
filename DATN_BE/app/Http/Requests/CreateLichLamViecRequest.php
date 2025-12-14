<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateLichLamViecRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_nhan_vien' => 'nullable|integer|exists:nhan_viens,id',
            'id_giao_vien' => 'nullable|integer|exists:giao_viens,id',
            'ngay_lam_viec' => 'required|date',
            'ca_lam_viec' => 'required|integer|in:1,2,3',
        ];
    }

    public function messages(): array
    {
        return [
            'id_nhan_vien.nullable' => 'ID nhân viên có thể để trống.',
            'id_nhan_vien.integer' => 'ID nhân viên phải là số nguyên.',
            'id_nhan_vien.exists' => 'Nhân viên không tồn tại trong hệ thống.',

            'id_giao_vien.nullable' => 'ID giáo viên có thể để trống.',
            'id_giao_vien.integer' => 'ID giáo viên phải là số nguyên.',
            'id_giao_vien.exists' => 'Giáo viên không tồn tại trong hệ thống.',

            'ngay_lam_viec.required' => 'Ngày làm việc không được để trống.',
            'ngay_lam_viec.date' => 'Ngày làm việc phải là định dạng ngày hợp lệ (YYYY-MM-DD).',

            'ca_lam_viec.required' => 'Ca làm việc không được để trống.',
            'ca_lam_viec.integer' => 'Ca làm việc phải là số nguyên.',
            'ca_lam_viec.in' => 'Ca làm việc phải là 1 (Ca sáng), 2 (Ca chiều), hoặc 3 (Ca tối).',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (empty($this->id_nhan_vien) && empty($this->id_giao_vien)) {
                $validator->errors()->add('id_nhan_vien', 'Phải có ít nhất một trong hai: nhân viên hoặc giáo viên.');
                $validator->errors()->add('id_giao_vien', 'Phải có ít nhất một trong hai: nhân viên hoặc giáo viên.');
            }

            if (!empty($this->id_nhan_vien) && !empty($this->id_giao_vien)) {
                $validator->errors()->add('id_nhan_vien', 'Chỉ được chọn một trong hai: nhân viên hoặc giáo viên.');
                $validator->errors()->add('id_giao_vien', 'Chỉ được chọn một trong hai: nhân viên hoặc giáo viên.');
            }
        });
    }
}
