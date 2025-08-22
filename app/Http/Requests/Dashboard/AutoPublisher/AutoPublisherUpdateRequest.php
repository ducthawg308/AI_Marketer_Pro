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
            'ad_id' => 'sometimes|integer|exists:ads,id',
            'user_page_id' => 'sometimes|integer|exists:user_pages,id',
            'scheduled_time' => 'sometimes|date|after:now',
            'status' => 'sometimes|in:pending,posted,failed',
            'is_recurring' => 'sometimes|boolean',
            'recurrence_interval' => 'nullable|string|max:50',
        ];
    }
}
