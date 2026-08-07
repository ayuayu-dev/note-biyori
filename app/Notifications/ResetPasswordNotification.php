<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    /**
     * パスワード再設定トークン
     */
    public function __construct(
        protected string $token
    ) {
    }

    /**
     * 通知の送信方法を取得
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * メールを組み立てる
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('【ノートびより】パスワード再設定のご案内')
            ->text(
                //プレーンテキスト用のテンプレートを使ってメール本文を作る
                //実ファイル）resources/views/mail/password-reset.blade.phpという
                'mail.password-reset',
                [
                    //パスワード再設定URL
                    'url' => $this->resetUrl($notifiable),
                ]
            );
    }

    /**
     * パスワード再設定URLを生成
     */
    protected function resetUrl(object $notifiable): string
    {
        return url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));
    }
}