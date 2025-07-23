<?php

namespace App\Http\Requests\Dashboard\AudienceConfig;

use Illuminate\Foundation\Http\FormRequest;

class AudienceConfigStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:products,name',
            'industry' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_customer_age_range' => 'nullable|string|max:255',
            'target_customer_income_level' => 'nullable|string|max:255',
            'target_customer_interests' => 'nullable|string',
            'competitor_name' => 'nullable|string|max:255',
            'competitor_url' => 'nullable|url|max:255',
            'competitor_description' => 'nullable|string',
        ];
    }
}