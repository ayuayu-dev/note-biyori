<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class NoteBiyoriPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 全ユーザーを取得（100人想定）
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->warn('ユーザーが存在しません。先にNoteBiyoriUserSeederを実行してください。');
            return;
        }

        // コピー元の元画像パス（storage/app/public/posts/test_post_0001.jpg）
        $sourceFileName = 'posts/test_post_0001.jpg';
        
        if (!Storage::disk('public')->exists($sourceFileName)) {
            $this->command->error("コピー元の画像が見つかりません: storage/app/public/{$sourceFileName}");
            return;
        }

        $counter = 1;

        // 1ユーザーあたり20件の投稿を作成（合計 100人 × 20件 = 2,000件）
        foreach ($users as $user) {
            for ($i = 0; $i < 20; $i++) {
                // 4桁のゼロ埋めファイル名を生成 (例: test_post_0001.jpg 〜 test_post_2000.jpg)
                $fileName = sprintf('test_post_%04d.jpg', $counter);
                $destinationPath = 'posts/' . $fileName;

                // 2枚目以降は元画像をストレージ内でコピーする
                if ($counter > 1) {
                    Storage::disk('public')->copy($sourceFileName, $destinationPath);
                }

                // 1. PostFactory を利用して投稿データを作成・紐付け
                $post = Post::factory()->create([
                    'user_id' => $user->id,
                ]);

                // 2. 投稿画像データ (post_images) を作成・紐付け
                $post->images()->create([
                    'image_path' => 'posts/' . $fileName,
                    'sort_order' => 0, // 必要に応じて並び順
                ]);

                $counter++;
            }
        }

        $this->command->info('2,000件のテスト投稿と画像の作成が完了しました！🎉');
    }
}