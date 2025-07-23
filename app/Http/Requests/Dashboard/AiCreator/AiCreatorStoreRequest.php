<?php

namespace App\Http\Requests\Dashboard\AiCreator;

use Illuminate\Foundation\Http\FormRequest;

class AiCreatorStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id'    => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'ad_title'   => 'required|string|max:255',
            'ad_content' => 'required|string',
            'hashtags'   => 'nullable|string|max:255',
            'emojis'     => 'nullable|string|max:255',
            'status'     => 'in:draft,approved,archived',
        ];
    }
}
