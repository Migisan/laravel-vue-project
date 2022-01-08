<?php

namespace App\Repositories;

// use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\ArticleRepositoryInterface;
use App\Article;

class ArticleRepository implements ArticleRepositoryInterface
{
  /**
   * ユーザーの記事一覧を取得
   * 
   * @param int $user_id
   * @return Collection
   */
  public function getArticleListByUser(int $user_id): Collection
  {
    return Article::with(['user'])->where('user_id', $user_id)->orderBy('created_at', 'desc')->get();
  }
}
