<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
/**
     * リクエストの実行可否を判定する。
     * ログイン済みのユーザーであれば誰でも利用可能。
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * プロフィール更新画面のバリデーションルール
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:10'],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
        ];
    }

    /**
     * バリデーションエラーメッセージ
     */
    public function messages(): array
    {
        return [
            'required' => ':attributeをご入力ください。',
            'email' => 'メールアドレスの形式で入力してください。',
            'unique' => 'この:attributeは使用できません。',

            'min.string' => ':attributeは:min文字以上で入力してください。',
            'max.string' => ':attributeは:max文字以内で入力してください。',
        ];
    }

    /**
     * フォーム項目名
     */
    public function attributes(): array
    {
        return [
            'name' => 'ユーザー名',
            'email' => 'メールアドレス',
        ];
    }

}
