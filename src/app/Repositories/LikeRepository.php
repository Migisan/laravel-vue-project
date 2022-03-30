<?php

namespace App\Repositories;

use App\Models\Like;

class LikeRepository implements LikeRepositoryInterface
{
  /**
   * 登録
   * 
   * @return \App\Models\Like
   */
  public function insert(array $params): \App\Models\Like
  {
    $like = new Like();

    $like->fill($params)->save();

    return $like;
  }
}
