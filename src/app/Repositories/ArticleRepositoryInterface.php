<?php

namespace App\Repositories;

interface ArticleRepositoryInterface
{
  /**
   * 記事一覧を取得
   * 
   * @return \Illuminate\Pagination\LengthAwarePaginator
   */
  public function getList(): \Illuminate\Pagination\LengthAwarePaginator;

  /**
   * ユーザーの記事一覧を取得
   * 
   * @param int $user_id
   * @return \Illuminate\Database\Eloquent\Collection
   */
  public function getListByUser(int $user_id): \Illuminate\Database\Eloquent\Collection;

  /**
   * 記事取得
   * 
   * @param int $id
   * @return \App\Models\Article
   */
  public function find($id): \App\Models\Article;

  /**
   * 記事を登録
   * 
   * @param array $params
   * @param int $user_id
   * @return \App\Models\Article
   */
  public function insert(array $params, int $user_id): \App\Models\Article;

  /**
   * 記事を更新
   * 
   * @param int $id
   * @param array $params
   * @return \App\Models\Article
   */
  public function update(int $id, array $params): \App\Models\Article;

  /**
   * 記事を削除
   * 
   * @param int $id
   * @return void
   */
  public function delete(int $id): void;
}
