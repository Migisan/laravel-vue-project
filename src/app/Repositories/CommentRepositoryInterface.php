<?php

namespace App\Repositories;

interface CommentRepositoryInterface
{
  /**
   * コメントを登録
   * 
   * @param array $params
   * @param int $user_id
   * @return \App\Models\Comment
   */
  public function insert(array $params, int $user_id): \App\Models\Comment;
}
