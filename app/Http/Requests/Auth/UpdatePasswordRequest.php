<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * リクエストの実行可否を判定する。
     * ログイン中ユーザーはパスワード変更が利用できるため true を返す。
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * マイプロフィールのパスワード変更のバリデーションルール
     */
    public function rules(): array
    {
        return [
            'current_password' => [
                'required',
                'current_password',
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
            'confirmed' => 'パスワード（確認用）が一致していません。',
            'current_password' => '現在のパスワードが正しくありません。',
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
            'current_password' => '現在のパスワード',
            'password' => 'パスワード',
            'password_confirmation' => 'パスワード（確認用）',
        ];
    }
}
