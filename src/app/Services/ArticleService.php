<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

use App\Services\ArticleServiceInterface;

use App\Repositories\ArticleRepositoryInterface;
use App\Repositories\UserRepositoryInterface;

class ArticleService implements ArticleServiceInterface
{
  private $article_repository;

  /**
   * コンストラクタ
   */
  public function __construct(UserRepositoryInterface $user_repository, ArticleRepositoryInterface $article_repository)
  {
    // DI
    $this->user_repository = $user_repository;
    $this->article_repository = $article_repository;
  }

  /**
   * 記事一覧を取得
   * 
   * @return LengthAwarePaginator
   */
  public function getArticleList(): LengthAwarePaginator
  {
    $articles = $this->article_repository->getList();

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
    $articles = $this->article_repository->getListByUser($user_id);

    return $articles;
  }

  /**
   * 記事を登録
   * 
   * @param array $input
   * @return \App\Models\Article
   */
  public function storeArticle(array $input): \App\Models\Article
  {
    // ログイン中ユーザー
    $auth = $this->user_repository->getAuth();

    // 登録
    $article = $this->article_repository->insert($input, $auth->id);

    return $article;
  }

  /**
   * 記事を更新
   * 
   * @param int $id
   * @param array $input
   * @return \App\Models\Article
   */
  public function updateArticle(int $id, array $input): \App\Models\Article
  {
    // 更新
    $article = $this->article_repository->update($id, $input);

    return $article;
  }

  /**
   * 記事を削除
   * 
   * @param int $id
   * @return void
   */
  public function deleteArticle(int $id): void
  {
    // 削除
    $this->article_repository->delete($id);
  }
}
