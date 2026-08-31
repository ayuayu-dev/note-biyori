<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * リクエストの実行可否を判定する。
     * 投稿機能はログインユーザーのみ利用できるため、
     * 認証済みユーザーからのリクエストを許可する。
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * 新規投稿画面のバリデーションルール
     */
    public function rules(): array
    {
        return [
            'image' => [
                'required',
                'image',
                'mimes:jpeg,png,webp',
                'max:5120',
            ],
        ];
    }

    /**
     * バリデーションエラーメッセージ
     */
    public function messages(): array
    {
        return [
            'required' => ':attributeをご選択ください。',
            'image' => ':attributeは画像ファイルを選択してください。',
            'mimes' => ':attributeはJPEG、PNG、WebP形式の画像を選択してください。',
            'max' => ':attributeは5MB以内の画像を選択してください。',
        ];
    }

    /**
     * フォーム項目名
     */
    public function attributes(): array
    {
        return [
            'image' => '画像',
        ];
    }
}