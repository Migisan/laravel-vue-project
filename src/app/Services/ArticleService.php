<?php

namespace App\Services;

use App\Services\ArticleServiceInterface;

use App\Repositories\ArticleRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\LikeRepositoryInterface;

class ArticleService implements ArticleServiceInterface
{
  private $user_repository;
  private $article_repository;
  private $like_repository;

  /**
   * コンストラクタ
   */
  public function __construct(
    UserRepositoryInterface $user_repository,
    ArticleRepositoryInterface $article_repository,
    LikeRepositoryInterface $like_repository
  ) {
    // DI
    $this->user_repository = $user_repository;
    $this->article_repository = $article_repository;
    $this->like_repository = $like_repository;
  }

  /**
   * 記事一覧を取得
   * 
   * @return \Illuminate\Pagination\LengthAwarePaginator
   */
  public function getArticleList(): \Illuminate\Pagination\LengthAwarePaginator
  {
    $articles = $this->article_repository->getList();

    return $articles;
  }

  /**
   * ユーザーの記事一覧を取得
   * 
   * @param int $user_id
   * @return \Illuminate\Database\Eloquent\Collection
   */
  public function getArticleListByUser(int $user_id): \Illuminate\Database\Eloquent\Collection
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

  /**
   * いいねをつける
   * 
   * @param int $id
   * @return void
   */
  public function addLikeToArticle(int $id): void
  {
    // ログイン中ユーザー
    $auth = $this->user_repository->getAuth();

    $params = [
      'user_id' => $auth->id,
      'article_id' => $id,
    ];

    $this->like_repository->insert($params);
  }

  /**
   * いいねを外す
   * 
   * @param int $id
   * @return void
   */
  public function deleteLikeToArticle(int $id): void
  {
    // ログイン中ユーザー
    $auth = $this->user_repository->getAuth();

    $article_id = $id;
    $user_id = $auth->id;

    $this->like_repository->delete($article_id, $user_id);
  }
}
