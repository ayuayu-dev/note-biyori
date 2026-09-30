<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RecentPostController extends Controller
{
    public function index(): Response
    {
        // 投稿を新しい順に、画像とユーザー情報も一緒に10件ずつ取得
        $posts = Post::with(['images', 'user'])
            ->latest()
            ->paginate(10);

        return Inertia::render('Posts/Recent', [
            'posts' => $posts,
        ]);
    }
}