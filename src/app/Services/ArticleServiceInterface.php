<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

interface ArticleServiceInterface
{
  /**
   * ユーザーの記事一覧を取得
   * 
   * @param int $user_id
   * @return Collection
   */
  public function getArticleListByUser(int $user_id): Collection;
}
