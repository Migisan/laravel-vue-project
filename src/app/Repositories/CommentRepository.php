<?php

namespace App\Repositories;

use App\Repositories\CommentRepositoryInterface;

use App\Models\Comment;

class CommentRepository implements CommentRepositoryInterface
{
  /**
   * コメントを登録
   * 
   * @param array $params
   * @param int $user_id
   * @return \App\Models\Comment
   */
  public function insert(array $params, int $user_id): \App\Models\Comment
  {
    $comment = new Comment();

    $comment->user_id = $user_id;

    $comment->fill($params)->save();

    return $comment;
  }
}
