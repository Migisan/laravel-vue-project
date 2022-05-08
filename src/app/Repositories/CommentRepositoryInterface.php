<?php

namespace App\Repositories;

interface CommentRepositoryInterface
{
  /**
   * 一覧取得
   * 
   * @param int $article_id
   * @return \Illuminate\Database\Eloquent\Collection
   */
  public function getListByArticleId(int $article_id): \Illuminate\Database\Eloquent\Collection;

  /**
   * コメントを登録
   * 
   * @param array $params
   * @param int $user_id
   * @return \App\Models\Comment
   */
  public function insert(array $params, int $user_id): \App\Models\Comment;
}
