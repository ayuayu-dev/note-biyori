<?php

namespace App\Models;

use Database\Factories\NoteBiyoriPostFactory; // インポートを追加
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory; // 追加
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    /**
     * このモデルに対応するファクトリーを指定
     */
    protected static function newFactory(): Factory
    {
        return NoteBiyoriPostFactory::new(); // 作成した専用ファクトリーを返す
    }

    /**
     * 一括代入可能な属性
     */
    protected $fillable = [
        'user_id',
    ];
    
    /**
     * 投稿に紐づく画像を取得
     */
    public function images(): HasMany
    {
        return $this->hasMany(PostImage::class);
    }

    /**
     * 投稿者を取得
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}