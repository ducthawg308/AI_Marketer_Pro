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
            'product_id' => 'required|exists:products,id',
            'ai_setting_id' => 'required|exists:ai_settings,id',
            'ad_title'   => 'required|string|max:255',
        ];
    }
}
