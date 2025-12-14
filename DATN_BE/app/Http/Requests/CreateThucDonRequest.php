<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateThucDonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     * Normalize id_mon_ans to id_mon_an for consistent handling
     */
    protected function prepareForValidation(): void
    {
        // If id_mon_ans is provided, use it as id_mon_an
        if ($this->has('id_mon_ans') && !$this->has('id_mon_an')) {
            $this->merge([
                'id_mon_an' => $this->id_mon_ans,
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'ten_thuc_don' => 'required|string|max:255',
            'ngay' => 'required|date',
            'id_bua_an' => 'required|integer|in:1,2,3,4,5',
            'id_mon_an' => 'required|array|min:1',
            'id_mon_an.*' => 'required|integer|exists:mon_ans,id',
            'mo_ta' => 'nullable|string',
            'id_lop_hoc' => 'nullable|integer|exists:lop_hocs,id',
        ];
    }

    public function messages(): array
    {
        return [
            'ten_thuc_don.required' => 'Tên thực đơn không được để trống.',
            'ten_thuc_don.string' => 'Tên thực đơn phải là chuỗi.',
            'ten_thuc_don.max' => 'Tên thực đơn không được vượt quá 255 ký tự.',

            'ngay.required' => 'Ngày áp dụng không được để trống.',
            'ngay.date' => 'Ngày áp dụng phải là định dạng ngày hợp lệ.',

            'id_bua_an.required' => 'Loại bữa không được để trống.',
            'id_bua_an.integer' => 'Loại bữa không hợp lệ.',
            'id_bua_an.in' => 'Loại bữa phải là: Bữa sáng, Bữa phụ sáng, Bữa trưa, Bữa phụ chiều hoặc Bữa chiều.',

            'id_mon_an.required' => 'Vui lòng chọn ít nhất một món ăn.',
            'id_mon_an.array' => 'Danh sách món ăn không hợp lệ.',
            'id_mon_an.min' => 'Vui lòng chọn ít nhất một món ăn.',
            'id_mon_an.*.required' => 'Mỗi món ăn phải có ID hợp lệ.',
            'id_mon_an.*.integer' => 'ID món ăn phải là số nguyên.',
            'id_mon_an.*.exists' => 'Một hoặc nhiều món ăn không tồn tại.',

            'mo_ta.string' => 'Mô tả phải là chuỗi.',

            'id_lop_hoc.integer' => 'Lớp học không hợp lệ.',
            'id_lop_hoc.exists' => 'Lớp học không tồn tại.',
        ];
    }
}
