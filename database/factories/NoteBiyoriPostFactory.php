<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User; // App\Models\User を使えるようにインポート
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class NoteBiyoriPostFactory extends Factory
{
    // モデルの紐付けを明示的に指定
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 単体テスト時（Tinker等）にエラーにならないよう user_id のデフォルトを用意
            'user_id' => User::factory(), 
        ];
    }
}