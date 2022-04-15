<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\ArticleStoreRequest;

use App\Http\Resources\ArticleResource;

use App\Services\ArticleServiceInterface;

class ArticleController extends Controller
{
    /**
     * プロパティ
     */
    private $article_service;

    /**
     * コンストラクタ
     */
    public function __construct(ArticleServiceInterface $article_service)
    {
        // ミドルウェア
        $this->middleware('auth')->except(['index', 'show']);
        // DI
        $this->article_service = $article_service;
    }

    /**
     * 記事一覧
     *
     * @return Response
     */
    public function index()
    {
        $articles = $this->article_service->getArticleList();

        return ArticleResource::collection($articles);
    }

    /**
     * 記事登録画面
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * 記事登録処理
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleStoreRequest $request)
    {
        // リクエスト
        $input = $request->only(['title', 'body']);

        // 登録
        $article = $this->article_service->storeArticle($input);

        return new ArticleResource($article);
    }

    /**
     * 記事詳細画面
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $article = $this->article_service->findArticle($id);

        return new ArticleResource($article);
    }

    /**
     * 記事編集画面
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 記事更新処理
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleStoreRequest $request, int $id)
    {
        // リクエスト
        $input = $request->only(['title', 'body']);

        // 更新
        $article = $this->article_service->updateArticle($id, $input);

        return new ArticleResource($article);
    }

    /**
     * 記事削除処理
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        // 削除
        $this->article_service->deleteArticle($id);
    }

    /**
     * いいねつける処理
     * 
     * @param int $id
     */
    public function addLike(int $id)
    {
        // いいねをつける
        $this->article_service->addLikeToArticle($id);

        // 記事取得
        $article = $this->article_service->findArticle($id);

        return new ArticleResource($article);
    }

    /**
     * いいね外す処理
     * 
     * @param int $id
     */
    public function deleteLike(int $id)
    {
        // いいねを外す
        $this->article_service->deleteLikeToArticle($id);

        // 記事取得
        $article = $this->article_service->findArticle($id);

        return new ArticleResource($article);
    }
}
