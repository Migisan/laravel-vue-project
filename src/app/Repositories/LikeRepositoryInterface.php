<?php

namespace App\Repositories;

interface LikeRepositoryInterface
{
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
