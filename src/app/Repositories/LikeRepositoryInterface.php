<?php

namespace App\Repositories;

interface LikeRepositoryInterface
{
  /**
   * 一覧取得
   * 
   * @param int $article_id
   * @return \Illuminate\Database\Eloquent\Collection
   */
  public function getListByArticleId(int $article_id): \Illuminate\Database\Eloquent\Collection;

  /**
   * 登録
   * 
   * @param array $params
   * @return \App\Models\Like
   */
  public function insert(array $params): \App\Models\Like;

  /**
   * 削除
   * 
   * @param int $article_id
   * @param int $user_id
   * @return void
   */
  public function delete(int $article_id, int $user_id): void;
}
