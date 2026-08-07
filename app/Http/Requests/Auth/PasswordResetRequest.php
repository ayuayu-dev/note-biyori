<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class PasswordResetRequest extends FormRequest
{
    /**
     * リクエストの実行可否を判定する。
     * パスワード再設定は誰でも利用できるため true を返す。
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * パスワード再設定画面のバリデーションルール
     */
    public function rules(): array
    {
        return [
            
            'token' => [
                'required',
            ],

            'email' => [
                'required',
                'email',
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
            'confirmed' => 'パスワード（確認用）が一致していません。',
        ];
    }

    /**
     * フォーム項目名
     */
    public function attributes(): array
    {
        return [
            'email' => 'メールアドレス',
            'password' => 'パスワード',
            'password_confirmation' => 'パスワード（確認用）',
        ];
    }
}
