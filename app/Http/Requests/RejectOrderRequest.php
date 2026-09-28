<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RejectOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reject_reason' => ['required', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'reject_reason.required' => '差し戻し理由を入力してください。',
            'reject_reason.max' => '差し戻し理由は1000文字以内で入力してください。',
        ];
    }
}