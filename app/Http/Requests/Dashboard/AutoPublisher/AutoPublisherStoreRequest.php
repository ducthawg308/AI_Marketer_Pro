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
            'ad_id' => 'required|integer|exists:ads,id',
            'user_page_id' => 'required|integer|exists:user_pages,id',
            'scheduled_time' => 'required|date|after:now',
            'status' => 'required|in:pending,posted,failed',
            'is_recurring' => 'required|boolean',
            'recurrence_interval' => 'nullable|string|max:50',
        ];
    }
}
