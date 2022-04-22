<?php

namespace App\Repositories;

use App\Repositories\ArticleRepositoryInterface;

use App\Models\Article;

class ArticleRepository implements ArticleRepositoryInterface
{
  /**
   * 記事一覧を取得
   * 
   * @return \Illuminate\Pagination\LengthAwarePaginator
   */
  public function getList(): \Illuminate\Pagination\LengthAwarePaginator
  {
    return Article::with(['user', 'comments', 'likes'])->orderBy('updated_at', 'desc')->paginate();
  }

  /**
   * ユーザーの記事一覧を取得
   * 
   * @param int $user_id
   * @return \Illuminate\Database\Eloquent\Collection
   */
  public function getListByUser(int $user_id): \Illuminate\Database\Eloquent\Collection
  {
    return Article::with(['user', 'likes'])->where('user_id', $user_id)->orderBy('updated_at', 'desc')->get();
  }

  /**
   * 記事取得
   * 
   * @param int $id
   * @return \App\Models\Article
   */
  public function find($id): \App\Models\Article
  {
    return Article::with(['user', 'likes'])->find($id);
  }

  /**
   * 記事を登録
   * 
   * @param array $params
   * @param int $user_id
   * @return \App\Models\Article
   */
  public function insert(array $params, int $user_id): \App\Models\Article
  {
    $article = new Article();

    $article->user_id = $user_id;

    $article->fill($params)->save();

    return $article;
  }

  /**
   * 記事を更新
   * 
   * @param int $id
   * @param array $params
   * @return \App\Models\Article
   */
  public function update(int $id, array $params): \App\Models\Article
  {
    $article = Article::find($id);

    $article->fill($params)->save();

    return $article;
  }

  /**
   * 記事を削除
   * 
   * @param int $id
   * @return void
   */
  public function delete(int $id): void
  {
    $article = Article::find($id);

    $article->delete();
  }
}
