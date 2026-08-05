<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class RegisterRequest extends FormRequest
{
    /**
     * リクエストの実行可否を判定する。
     * 新規登録は誰でも利用できるため true を返す。
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * 新規登録画面のバリデーションルール
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
                'unique:users',
            ],

            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults(),
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
            'confirmed' => 'パスワード（確認用）が一致していません。',

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
            'password' => 'パスワード',
            'password_confirmation' => 'パスワード（確認用）',
        ];
    }
}
