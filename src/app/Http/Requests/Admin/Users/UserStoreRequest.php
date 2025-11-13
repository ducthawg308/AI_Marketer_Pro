<?php

namespace App\Http\Requests\Admin\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'min:2',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
            'password_confirmation' => [
                'required',
                'string',
            ],
            'role' => [
                'required',
                'string',
                Rule::in(['admin', 'user']),
            ],
            'roles' => [
                'nullable',
                'array',
            ],
            'roles.*' => [
                'string',
                'exists:roles,name',
            ],
            'permissions' => [
                'nullable',
                'array',
            ],
            'permissions.*' => [
                'string',
                'exists:permissions,name',
            ],
            'google_id' => [
                'nullable',
                'string',
                'max:255',
                'unique:users,google_id',
            ],
            'facebook_id' => [
                'nullable',
                'string',
                'max:255',
                'unique:users,facebook_id',
            ],
            'facebook_access_token' => [
                'nullable',
                'string',
            ],
            'facebook_token_expires_at' => [
                'nullable',
                'date',
            ],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'tên người dùng',
            'email' => 'email',
            'password' => 'mật khẩu',
            'password_confirmation' => 'xác nhận mật khẩu',
            'role' => 'vai trò',
            'roles' => 'danh sách vai trò',
            'permissions' => 'danh sách quyền',
            'google_id' => 'Google ID',
            'facebook_id' => 'Facebook ID',
            'facebook_access_token' => 'Facebook Access Token',
            'facebook_token_expires_at' => 'thời gian hết hạn Facebook Token',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập :attribute.',
            'name.string' => ':attribute phải là chuỗi ký tự.',
            'name.max' => ':attribute không được vượt quá :max ký tự.',
            'name.min' => ':attribute phải có ít nhất :min ký tự.',
            
            'email.required' => 'Vui lòng nhập :attribute.',
            'email.email' => ':attribute không đúng định dạng.',
            'email.max' => ':attribute không được vượt quá :max ký tự.',
            'email.unique' => ':attribute đã tồn tại trong hệ thống.',
            
            'password.required' => 'Vui lòng nhập :attribute.',
            'password.confirmed' => 'Xác nhận :attribute không khớp.',
            'password.min' => ':attribute phải có ít nhất :min ký tự.',
            
            'password_confirmation.required' => 'Vui lòng nhập :attribute.',
            
            'role.required' => 'Vui lòng chọn :attribute.',
            'role.in' => ':attribute không hợp lệ.',
            
            'roles.array' => ':attribute phải là một mảng.',
            'roles.*.exists' => 'Vai trò được chọn không tồn tại.',
            
            'permissions.array' => ':attribute phải là một mảng.',
            'permissions.*.exists' => 'Quyền được chọn không tồn tại.',
            
            'google_id.unique' => ':attribute đã được sử dụng.',
            'facebook_id.unique' => ':attribute đã được sử dụng.',
            'facebook_token_expires_at.date' => ':attribute phải là ngày hợp lệ.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Trim whitespace from name and email
        if ($this->has('name')) {
            $this->merge([
                'name' => trim($this->name),
            ]);
        }

        if ($this->has('email')) {
            $this->merge([
                'email' => trim(strtolower($this->email)),
            ]);
        }
    }
}