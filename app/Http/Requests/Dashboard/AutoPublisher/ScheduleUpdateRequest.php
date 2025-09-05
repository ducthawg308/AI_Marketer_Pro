<?php

namespace App\Http\Requests\Dashboard\AutoPublisher;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'selected_ads' => 'nullable|array|min:1',
            'selected_ads.*' => 'integer|exists:ads,id',
            'selected_pages' => 'nullable|array|min:1',
            'selected_pages.*' => 'integer|exists:user_pages,id',
        ];
    }

    public function messages(): array
    {
        return [
            'selected_ads.array' => 'Dữ liệu quảng cáo không hợp lệ.',
            'selected_ads.min' => 'Vui lòng chọn ít nhất một quảng cáo.',
            'selected_ads.*.integer' => 'ID quảng cáo phải là số nguyên.',
            'selected_ads.*.exists' => 'Một hoặc nhiều quảng cáo đã chọn không tồn tại.',

            'selected_pages.array' => 'Dữ liệu trang không hợp lệ.',
            'selected_pages.min' => 'Vui lòng chọn ít nhất một trang để đăng.',
            'selected_pages.*.integer' => 'ID trang phải là số nguyên.',
            'selected_pages.*.exists' => 'Một hoặc nhiều trang đã chọn không tồn tại.',
        ];
    }
}
