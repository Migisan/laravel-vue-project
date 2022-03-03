<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    // 論理削除
    use SoftDeletes;

    /**
     * １ページあたりの項目数
     */
    protected $perPage;

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
     * コンストラクタ
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->perPage = config('const.PER_PAGE');
    }

    /**
     * Prepare a date for array / JSON serialization.
     * 
     * 日付のシリアル化をLaravel7以前のものに戻す(オーバライド)
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        $datetime_format = config('const.DATETIME_FORMAT');

        return $date->format($datetime_format);
    }

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
