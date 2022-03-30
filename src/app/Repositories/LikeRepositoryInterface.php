<?php

namespace App\Repositories;

interface LikeRepositoryInterface
{
  /**
   * 登録
   * 
   * @return \App\Models\Like
   */
  public function insert(array $params): \App\Models\Like;
}
