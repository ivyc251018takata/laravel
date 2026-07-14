<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'item_name' => ['required', 'string', 'max:255'],
            'quantity' => ['required', 'integer', 'min:1'],
            'unit_price' => ['nullable', 'integer', 'min:0'],
            'memo' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'item_name.required' => '商品名を入力してください。',
            'item_name.max' => '商品名は255文字以内で入力してください。',

            'quantity.required' => '数量を入力してください。',
            'quantity.integer' => '数量は整数で入力してください。',
            'quantity.min' => '数量は1以上で入力してください。',

            'unit_price.integer' => '単価は整数で入力してください。',
            'unit_price.min' => '単価は0円以上で入力してください。',

            'memo.string' => '備考の形式が正しくありません。',
        ];
    }
}