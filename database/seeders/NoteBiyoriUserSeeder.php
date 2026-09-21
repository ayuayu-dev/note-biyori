<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Factories\NoteBiyoriUserFactory;

class NoteBiyoriUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ノートびより専用Factoryを使って100人作成してDBに保存
        NoteBiyoriUserFactory::new()->count(100)->create();
    }
}