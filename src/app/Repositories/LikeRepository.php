<?php

namespace App\Repositories;

use Exception;

use App\Models\Like;

class LikeRepository implements LikeRepositoryInterface
{
  /**
   * 一覧取得
   * 
   * @param int $article_id
   * @return \Illuminate\Database\Eloquent\Collection
   */
  public function getListByArticleId(int $article_id): \Illuminate\Database\Eloquent\Collection
  {
    $likes = Like::with(['user'])
      ->where('article_id', $article_id)
      ->orderby('created_at', 'desc')
      ->get();

    return $likes;
  }

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

    if (!isset($like)) {
      throw new Exception('この記事に対するいいねはありません。');
    }

    $like->delete();
  }
}
