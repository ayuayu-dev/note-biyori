<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        //アカウント新規登録画面を表示する
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        //入力内容をバリデーションでチェック
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        //usersテーブルへユーザー情報を登録
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            //パスワードはハッシュ化する
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        //ユーザー情報登録処理後は自動ログイン
        Auth::login($user);

        //登録完了後、ホーム画面へ飛ぶ
        return redirect(route('dashboard', absolute: false));
    }
}
