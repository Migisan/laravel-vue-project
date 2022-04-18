<?php

namespace App\Services;

interface LikeServiceInterface
{
  /**
   * いいね一覧を取得
   * 
   * @param int $article_id
   * @return \Illuminate\Database\Eloquent\Collection
   */
  public function getLikeListByArticle(int $article_id): \Illuminate\Database\Eloquent\Collection;
}
