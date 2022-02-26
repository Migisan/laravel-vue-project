<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ArticleServiceInterface
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

  /**
   * 記事を登録
   * 
   * @param array $input
   * @return \App\Models\Article
   */
  public function storeArticle(array $input): \App\Models\Article;

  /**
   * 記事を更新
   * 
   * @param int $id
   * @param array $input
   * @return \App\Models\Article
   */
  public function updateArticle(int $id, array $input): \App\Models\Article;

  /**
   * 記事を削除
   * 
   * @param int $id
   * @return void
   */
  public function deleteArticle(int $id): void;
}
