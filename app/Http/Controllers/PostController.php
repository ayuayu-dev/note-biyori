<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;

class PostController extends Controller
{
    /**
     * 投稿を保存する
     */
    public function store(StorePostRequest $request)
    {
        $path = $request->file('image')->store('posts', 'public');

        dd($path);
    }
}