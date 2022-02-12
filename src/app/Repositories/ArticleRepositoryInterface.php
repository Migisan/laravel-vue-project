<?php

namespace App\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ArticleRepositoryInterface
{
  /**
   * 記事一覧を取得
   * 
   * @return LengthAwarePaginator
   */
  public function getArticleList(): LengthAwarePaginator;

  /**
   * ユーザーの記事一覧を取得
   * 
   * @param int $user_id
   * @return Collection
   */
  public function getArticleListByUser(int $user_id): Collection;
}
