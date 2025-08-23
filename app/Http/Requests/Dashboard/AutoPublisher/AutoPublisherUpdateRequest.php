<?php

namespace App\Http\Requests\Dashboard\AutoPublisher;

use Illuminate\Foundation\Http\FormRequest;

class AutoPublisherUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

        ];
    }
}
