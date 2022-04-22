<?php

namespace App\Services;

interface CommentServiceInterface
{
  /**
   * コメントを登録
   * 
   * @param array $input
   * @return \App\Models\Comment
   */
  public function storeComment(array $input): \App\Models\Comment;
}
