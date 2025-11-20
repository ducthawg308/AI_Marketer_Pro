<?php

namespace App\Http\Requests\Dashboard\AutoPublisher;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CampaignStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'objective' => [
                'required',
                Rule::in(['brand_awareness', 'reach', 'engagement', 'traffic', 'lead_generation', 'app_promotion', 'conversions', 'sales', 'retention_loyalty', 'video_views'])
            ],
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'nullable|date|after:start_date',
            'platforms' => 'required|array|min:1',
            'platforms.*' => 'required|integer|exists:user_pages,id',
            'frequency' => 'required|in:daily,weekly,custom',
            'frequency_config' => 'nullable|array',
            'default_time_start' => 'required|date_format:H:i',
            'default_time_end' => 'required|date_format:H:i|after:default_time_start',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên chiến dịch là bắt buộc.',
            'name.string' => 'Tên chiến dịch phải là chuỗi ký tự.',
            'name.max' => 'Tên chiến dịch không được vượt quá 255 ký tự.',

            'description.string' => 'Mô tả chiến dịch phải là chuỗi ký tự.',

            'objective.required' => 'Mục tiêu chiến dịch là bắt buộc.',
            'objective.in' => 'Mục tiêu chiến dịch không hợp lệ.',

            'start_date.required' => 'Ngày bắt đầu là bắt buộc.',
            'start_date.date' => 'Ngày bắt đầu không hợp lệ.',
            'start_date.after_or_equal' => 'Ngày bắt đầu phải từ hôm nay trở đi.',

            'end_date.date' => 'Ngày kết thúc không hợp lệ.',
            'end_date.after' => 'Ngày kết thúc phải sau ngày bắt đầu.',

            'platforms.required' => 'Vui lòng chọn ít nhất một nền tảng.',
            'platforms.array' => 'Dữ liệu nền tảng không hợp lệ.',
            'platforms.min' => 'Vui lòng chọn ít nhất một nền tảng.',
            'platforms.*.required' => 'ID nền tảng là bắt buộc.',
            'platforms.*.integer' => 'ID nền tảng phải là số nguyên.',
            'platforms.*.exists' => 'Một số nền tảng đã chọn không tồn tại.',

            'frequency.required' => 'Kiểu tần suất là bắt buộc.',
            'frequency.in' => 'Kiểu tần suất không hợp lệ.',

            'default_time_start.required' => 'Giờ bắt đầu mặc định là bắt buộc.',
            'default_time_start.date_format' => 'Định dạng giờ bắt đầu không hợp lệ.',

            'default_time_end.required' => 'Giờ kết thúc mặc định là bắt buộc.',
            'default_time_end.date_format' => 'Định dạng giờ kết thúc không hợp lệ.',
            'default_time_end.after' => 'Giờ kết thúc phải sau giờ bắt đầu.',
        ];
    }

    protected function passedValidation(): void
    {
        // Validate pages ownership
        $user = Auth::user();
        $userPagesCount = \App\Models\Facebook\UserPage::where('user_id', $user->id)
            ->whereIn('id', $this->platforms)
            ->count();

        if ($userPagesCount !== count($this->platforms)) {
            $this->validator->errors()->add('platforms', 'Một số trang đã chọn không tồn tại hoặc không thuộc quyền sở hữu của bạn.');
        }
    }
}
