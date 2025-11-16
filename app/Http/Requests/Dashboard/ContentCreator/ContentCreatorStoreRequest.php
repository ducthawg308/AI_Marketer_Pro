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
            'product_id'    => 'required_if:type,product|exists:products,id',
            'link'          => 'required_if:type,link|url|max:255',
            'ai_setting_id' => 'required_if:type,product,link|exists:ai_settings,id|nullable',
            'ad_content'    => 'required_if:type,manual|string|max:10000',
            'hashtags'      => 'nullable|string|max:255',
            'emojis'        => 'nullable|string|max:255',
        ];
    }
}
