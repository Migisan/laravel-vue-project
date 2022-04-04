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

    /**
     * usersテーブル リレーション(親)
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function article(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Article', 'article_id', 'id', 'articles');
    }

    /**
     * usersテーブル リレーション(親)
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id', 'users');
    }
}
