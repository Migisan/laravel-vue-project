<?php

namespace App\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

use App\Models\Article;

interface ArticleRepositoryInterface
{
  /**
   * 記事一覧を取得
   * 
   * @return LengthAwarePaginator
   */
  public function getList(): LengthAwarePaginator;

  /**
   * ユーザーの記事一覧を取得
   * 
   * @param int $user_id
   * @return Collection
   */
  public function getListByUser(int $user_id): Collection;

  /**
   * 記事を登録
   * 
   * @param array $params
   * @param int $user_id
   * @return Article
   */
  public function insert(array $params, int $user_id): Article;

  /**
   * 記事を更新
   * 
   * @param int $id
   * @param array $params
   * @return Article
   */
  public function update(int $id, array $params): Article;

  /**
   * 記事を削除
   * 
   * @param int $id
   * @return void
   */
  public function delete(int $id): void;
}
