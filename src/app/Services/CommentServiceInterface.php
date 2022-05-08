<?php

namespace App\Services;

interface CommentServiceInterface
{
  /**
   * コメント一覧を取得
   * 
   * @param int $article_id
   * @return \Illuminate\Database\Eloquent\Collection
   */
  public function getCommentListByArticle(int $article_id): \Illuminate\Database\Eloquent\Collection;

  /**
   * コメントを登録
   * 
   * @param array $input
   * @return \App\Models\Comment
   */
  public function storeComment(array $input): \App\Models\Comment;
}
