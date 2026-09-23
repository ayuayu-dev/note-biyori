<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ノートびより用のSeederを順番に呼び出す
        $this->call([
            NoteBiyoriUserSeeder::class, // 1. テストユーザー100人を作成
            NoteBiyoriPostSeeder::class, // 2. 各ユーザーに投稿20件＆画像を作成
        ]);
    }
}