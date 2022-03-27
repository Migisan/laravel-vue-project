<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\SoftDeletes;
use DateTimeInterface;

class User extends Authenticatable
{
    use Notifiable;

    // 論理削除
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'image_path',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

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
     * articlesテーブル リレーション(子)
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\Article');
    }

    /**
     * likesテーブル リレーション
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function likes(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->BelongsToMany('App\Models\Article', 'likes');
    }
}
