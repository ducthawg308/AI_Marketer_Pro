<?php

namespace App\Http\Requests\Dashboard\AudienceConfig;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AudienceConfigUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productId = $this->route('product') ? $this->route('product')->id : $this->input('product_id');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'name')->ignore($productId),
            ],
            'industry' => 'required|string|max:255',
            'description' => 'nullable|string',
            'age_range' => 'nullable|string|max:255',
            'income_level' => 'nullable|string|max:255',
            'interests' => 'nullable|string',
            'competitor_name' => 'nullable|string|max:255',
            'competitor_url' => 'nullable|url|max:255',
            'competitor_description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên sản phẩm hoặc dịch vụ.',
            'name.unique' => 'Tên sản phẩm hoặc dịch vụ đã tồn tại.',
            'name.max' => 'Tên sản phẩm hoặc dịch vụ không được vượt quá 255 ký tự.',
            'industry.required' => 'Vui lòng chọn ngành nghề.',
            'industry.max' => 'Ngành nghề không được vượt quá 255 ký tự.',
            'age_range.max' => 'Độ tuổi không được vượt quá 255 ký tự.',
            'income_level.max' => 'Mức thu nhập không được vượt quá 255 ký tự.',
            'competitor_name.max' => 'Tên đối thủ không được vượt quá 255 ký tự.',
            'competitor_url.url' => 'URL đối thủ không hợp lệ.',
            'competitor_url.max' => 'URL đối thủ không được vượt quá 255 ký tự.',
        ];
    }
}