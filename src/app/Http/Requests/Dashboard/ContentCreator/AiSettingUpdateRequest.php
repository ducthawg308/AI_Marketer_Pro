<?php

namespace App\Http\Requests\Dashboard\ContentCreator;

use Illuminate\Foundation\Http\FormRequest;

class AiSettingUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tone' => 'sometimes|in:friendly,professional,funny,emotional',
            'length' => 'sometimes|in:short,medium,long',
            'platform' => 'sometimes|in:Facebook,Zalo,TikTok,Shopee',
            'language' => 'sometimes|in:Vietnamese,English',
        ];
    }

    public function messages(): array
    {
        return [
            'tone.in' => 'Giọng điệu không hợp lệ.',
            'length.in' => 'Độ dài không hợp lệ.',
            'platform.in' => 'Nền tảng không hợp lệ.',
            'language.in' => 'Ngôn ngữ không hợp lệ.',
        ];
    }
}
