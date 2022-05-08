<?php

namespace App\Services;

use App\Services\CommentServiceInterface;

use App\Repositories\CommentRepositoryInterface;
use App\Repositories\UserRepositoryInterface;

class CommentService implements CommentServiceInterface
{
  private $comment_repository;
  private $user_repository;

  /**
   * コンストラクタ
   */
  public function __construct(
    CommentRepositoryInterface $comment_repository,
    UserRepositoryInterface $user_repository
  ) {
    // DI
    $this->comment_repository = $comment_repository;
    $this->user_repository = $user_repository;
  }

  /**
   * コメント一覧を取得
   * 
   * @param int $article_id
   * @return \Illuminate\Database\Eloquent\Collection
   */
  public function getCommentListByArticle(int $article_id): \Illuminate\Database\Eloquent\Collection
  {
    $comments = $this->comment_repository->getListByArticleId($article_id);

    return $comments;
  }

  /**
   * コメントを登録
   * 
   * @param array $input
   * @return \App\Models\Comment
   */
  public function storeComment(array $input): \App\Models\Comment
  {
    // ログイン中ユーザー
    $auth = $this->user_repository->getAuth();

    // 登録
    $comment = $this->comment_repository->insert($input, $auth->id);

    return $comment;
  }
}
