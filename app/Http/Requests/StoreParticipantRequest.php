<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreParticipantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'join_code' => ['required', 'string', 'size:6'],
            'nickname' => ['required', 'string', 'max:255'],
            'memo' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'join_code.required' => '参加コードを入力してください。',
            'join_code.size' => '参加コードは6文字です。',

            'nickname.required' => 'ニックネームを入力してください。',
            'nickname.max' => 'ニックネームは255文字以内で入力してください。',

            'memo.string' => '備考の形式が正しくありません。',
        ];
    }
}