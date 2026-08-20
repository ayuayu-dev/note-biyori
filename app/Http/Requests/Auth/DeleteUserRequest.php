<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class DeleteUserRequest extends FormRequest
{
    /**
     * リクエストの実行可否を判定する。
     * ログイン中ユーザーはアカウント削除が利用できるため true を返す。
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * マイプロフィールのアカウント削除のバリデーションルール
     */
    public function rules(): array
    {
        return [
            'password' => [
                'required',
                'current_password',
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
            'current_password' => '現在のパスワードが正しくありません。',
        ];
    }

    /**
     * フォーム項目名
     */
    public function attributes(): array
    {
        return [
            'password' => 'パスワード',
        ];
    }
}
