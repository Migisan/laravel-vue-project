<?php

namespace App\Services;

interface ArticleServiceInterface
{
  /**
   * 記事一覧を取得
   * 
   * @return \Illuminate\Pagination\LengthAwarePaginator
   */
  public function getArticleList(): \Illuminate\Pagination\LengthAwarePaginator;

  /**
   * ユーザーの記事一覧を取得
   * 
   * @param int $user_id
   * @return \Illuminate\Database\Eloquent\Collection
   */
  public function getArticleListByUser(int $user_id): \Illuminate\Database\Eloquent\Collection;

  /**
   * 記事を登録
   * 
   * @param array $input
   * @return \App\Models\Article
   */
  public function storeArticle(array $input): \App\Models\Article;

  /**
   * 記事を更新
   * 
   * @param int $id
   * @param array $input
   * @return \App\Models\Article
   */
  public function updateArticle(int $id, array $input): \App\Models\Article;

  /**
   * 記事を削除
   * 
   * @param int $id
   * @return void
   */
  public function deleteArticle(int $id): void;

  /**
   * いいねをつける
   * 
   * @param int $id
   * @return void
   */
  public function addLikeToArticle(int $id): void;

  /**
   * いいねを外す
   * 
   * @param int $id
   * @return void
   */
  public function deleteLikeToArticle(int $id): void;
}
