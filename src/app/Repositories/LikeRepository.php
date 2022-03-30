<?php

namespace App\Repositories;

use App\Models\Like;

class LikeRepository implements LikeRepositoryInterface
{
  /**
   * 登録
   * 
   * @param array $params
   * @return \App\Models\Like
   */
  public function insert(array $params): \App\Models\Like
  {
    $like = new Like();

    $like->fill($params)->save();

    return $like;
  }

  /**
   * 削除
   * 
   * @param int $article_id
   * @param int $user_id
   * @return void
   */
  public function delete(int $article_id, int $user_id): void
  {
    $like = Like::where('article_id', $article_id)
      ->where('user_id', $user_id)
      ->first();

    $like->delete();
  }
}
