<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePartyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'table_number' => ['nullable', 'string', 'max:255'],
            'memo' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => '宴会名を入力してください。',
            'name.max' => '宴会名は255文字以内で入力してください。',
            'table_number.max' => 'テーブル番号は255文字以内で入力してください。',
            'memo.string' => '備考の形式が正しくありません。',
        ];
    }
}