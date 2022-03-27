<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends BaseModel
{

    // 論理削除
    use SoftDeletes;

    /**
     * ホワイトリスト
     * 
     * @var array
     */
    protected $fillable = [
        'title',
        'body',
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
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id', 'users');
    }

    /**
     * likesテーブル リレーション
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function likes(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->BelongsTo('App\Models\User', 'likes');
    }
}
