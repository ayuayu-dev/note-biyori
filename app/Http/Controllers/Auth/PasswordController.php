<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    /**
     * パスワードを更新する。
     */
    public function update(UpdatePasswordRequest $request): RedirectResponse
    {
        // バリデーション済みの入力値を取得する。
        $validated = $request->validated();

        // 新しいパスワードをハッシュ化して、ユーザー情報を更新する。
        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        // 元の画面へ戻る。
        return back();
    }
}
