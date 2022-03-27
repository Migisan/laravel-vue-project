<?php

namespace App\Models;

class Like extends BaseModel
{
    /**
     * ホワイトリスト
     * 
     * @var array
     */
    protected $fillable = [
        'article_id',
        'user_id',
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
}
