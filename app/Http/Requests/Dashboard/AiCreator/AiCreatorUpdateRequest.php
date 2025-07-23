<?php

namespace App\Http\Requests\Dashboard\AiCreator;

use Illuminate\Foundation\Http\FormRequest;

class AiCreatorUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ad_title'   => 'sometimes|required|string|max:255',
            'ad_content' => 'sometimes|required|string',
            'hashtags'   => 'nullable|string|max:255',
            'emojis'     => 'nullable|string|max:255',
            'status'     => 'in:draft,approved,archived',
        ];
    }
}
