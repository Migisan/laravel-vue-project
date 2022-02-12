<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use App\Services\ArticleServiceInterface;
use App\Repositories\ArticleRepositoryInterface;

class ArticleService implements ArticleServiceInterface
{
  private $article_repository;

  /**
   * コンストラクタ
   */
  public function __construct(ArticleRepositoryInterface $article_repository)
  {
    // DI
    $this->article_repository = $article_repository;
  }

  /**
   * 記事一覧を取得
   * 
   * @return LengthAwarePaginator
   */
  public function getArticleList(): LengthAwarePaginator
  {
    $articles = $this->article_repository->getArticleList();

    return $articles;
  }

  /**
   * ユーザーの記事一覧を取得
   * 
   * @param int $user_id
   * @return Collection
   */
  public function getArticleListByUser(int $user_id): Collection
  {
    $articles = $this->article_repository->getArticleListByUser($user_id);

    return $articles;
  }
}
