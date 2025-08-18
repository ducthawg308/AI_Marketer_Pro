<?php

namespace App\Http\Requests\Dashboard\ContentCreator;

use Illuminate\Foundation\Http\FormRequest;

class ContentCreatorUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type'       => 'sometimes|in:manual,product,link',
            'product_id' => 'sometimes|required_if:type,product|nullable|exists:products,id',
            'link'       => 'sometimes|required_if:type,link|nullable|url|max:255',
            'ad_title'   => 'sometimes|required|string|max:255',
            'ad_content' => 'sometimes|required_if:type,manual|string',
            'hashtags'   => 'nullable|string|max:255',
            'emojis'     => 'nullable|string|max:255',
            'status'     => 'sometimes|in:draft,approved',
        ];
    }
}
