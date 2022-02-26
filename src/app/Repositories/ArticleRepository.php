<?php

namespace App\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

use App\Repositories\ArticleRepositoryInterface;

use App\Models\Article;

class ArticleRepository implements ArticleRepositoryInterface
{
  /**
   * 記事一覧を取得
   * 
   * @return LengthAwarePaginator
   */
  public function getList(): LengthAwarePaginator
  {
    return Article::with(['user'])->orderBy('created_at', 'desc')->paginate();
  }

  /**
   * ユーザーの記事一覧を取得
   * 
   * @param int $user_id
   * @return Collection
   */
  public function getListByUser(int $user_id): Collection
  {
    return Article::with(['user'])->where('user_id', $user_id)->orderBy('created_at', 'desc')->get();
  }

  /**
   * 記事を登録
   * 
   * @param array $params
   * @param int $user_id
   * @return Article
   */
  public function insert(array $params, int $user_id): Article
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
   * @return Article
   */
  public function update(int $id, array $params): Article
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
