<?php

namespace App\Services;

use App\Repositories\LikeRepositoryInterface;

class LikeService implements LikeServiceInterface
{
  private $like_repository;

  /**
   * コンストラクタ
   */
  public function __construct(
    LikeRepositoryInterface $like_repository
  ) {
    // DI
    $this->like_repository = $like_repository;
  }

  /**
   * いいね一覧を取得
   * 
   * @param int $article_id
   * @return \Illuminate\Database\Eloquent\Collection
   */
  public function getLikeListByArticle(int $article_id): \Illuminate\Database\Eloquent\Collection
  {
    $likes = $this->like_repository->getListByArticleId($article_id);

    return $likes;
  }
}
