<?php

namespace App\Http\Requests\Dashboard\AutoPublisher;

use Illuminate\Foundation\Http\FormRequest;

class AutoPublisherStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'selected_ads' => 'required|array|min:1',
            'selected_ads.*' => 'integer|exists:ads,id',
            'selected_pages' => 'required|array|min:1',
            'selected_pages.*' => 'integer|exists:user_pages,id',
        ];
    }
}
