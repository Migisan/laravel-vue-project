<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends BaseModel
{
    /**
     * ホワイトリスト
     * 
     * @var array
     */
    protected $fillable = [
        'title',
        'body',
    ];

    /**
     * レスポンスに含めないデータ
     * 
     * @var array
     */
    protected $hidden = [];

    /**
     * レスポンスに含めるアクセサ
     * 
     * @var array
     */
    protected $appends = [];

    /**
     * usersテーブル リレーション(親)
     * 
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id', 'users');
    }
}
