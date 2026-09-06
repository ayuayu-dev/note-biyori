<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * 投稿を保存する
     */
    public function store(StorePostRequest $request)
    {
        // アップロードされた画像をStorage（storage\app\public）に保存する
        $path = $request->file('image')->store('posts', 'public');

        // ログイン中のユーザーに紐づく投稿を作成する
        $post = Post::create([
            'user_id' => $request->user()->id,
        ]);

        // 保存した画像を投稿に紐づけてpost_imagesに登録する
        $post->images()->create([
            'image_path' => $path,
            'sort_order' => 1,
        ]);
    }
}