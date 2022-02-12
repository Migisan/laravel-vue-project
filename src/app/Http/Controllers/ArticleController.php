<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Services\ArticleServiceInterface;
use App\Http\Requests\ArticleStoreRequest;
use App\Article;

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
        $this->middleware('auth')->except(['index']);
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

        return $articles;
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
        $article = new Article();

        $input = $request->all();
        $article->user_id = Auth::id();
        $article->fill($input)->save();

        return $article;
    }

    /**
     * 記事詳細画面
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
     * @param  Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleStoreRequest $request, Article $article)
    {
        $input = $request->all();
        $article->fill($input)->save();

        return $article;
    }

    /**
     * 記事削除処理
     *
     * @param  Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $article->delete();
    }
}
