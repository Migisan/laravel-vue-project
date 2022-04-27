<?php

namespace App\Repositories;

use App\Repositories\CommentRepositoryInterface;

use App\Models\Comment;

class CommentRepository implements CommentRepositoryInterface
{
  /**
   * 一覧取得
   * 
   * @param int $article_id
   * @return \Illuminate\Database\Eloquent\Collection
   */
  public function getListByArticleId(int $article_id): \Illuminate\Database\Eloquent\Collection
  {
    $comments = Comment::with(['user'])
      ->where('article_id', $article_id)
      ->orderby('created_at', 'desc')
      ->get();

    return $comments;
  }

  /**
   * 登録
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
