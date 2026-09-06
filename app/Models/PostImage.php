<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostImage extends Model
{
    /**
     * 一括代入可能な属性
     */
    protected $fillable = [
        'image_path',
        'sort_order',
    ];

    /**
     * 投稿を取得
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}