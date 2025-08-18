<?php

namespace App\Http\Requests\Dashboard\ContentCreator;

use Illuminate\Foundation\Http\FormRequest;

class ContentCreatorStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type'          => 'required|in:manual,product,link',
            'product_id'    => 'required_if:type,product|nullable|exists:products,id',
            'link'          => 'required_if:type,link|nullable|url|max:255',
            'ai_setting_id' => 'required|exists:ai_settings,id',
            'ad_title'      => 'required|string|max:255',
            'ad_content'    => 'required_if:type,manual|nullable|string',
            'hashtags'      => 'nullable|string|max:255',
            'emojis'        => 'nullable|string|max:255',
        ];
    }
}
