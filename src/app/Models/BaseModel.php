<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use DateTimeInterface;

class BaseModel extends Model
{
    // 論理削除
    use SoftDeletes;

    // １ページあたりの項目数
    protected $perPage;

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
}
