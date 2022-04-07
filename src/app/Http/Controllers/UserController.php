<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\UserUpdateRequest;

use App\Http\Resources\UserResource;
use App\Http\Resources\ArticleResource;

use App\Services\UserServiceInterface;
use App\Services\ArticleServiceInterface;

class UserController extends Controller
{
    /**
     * プロパティ
     */
    private $user_service;
    private $article_service;

    /**
     * コンストラクタ
     */
    public function __construct(UserServiceInterface $user_service, ArticleServiceInterface $article_service)
    {
        // ミドルウェア
        $this->middleware('auth')->except(['show']);
        // DI
        $this->user_service = $user_service;
        $this->article_service = $article_service;
    }

    /**
     * ユーザー一覧
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * ユーザー登録画面
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * ユーザー登録処理
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * ユーザー詳細画面
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $_user = $this->user_service->findUser($id);
        $user = new UserResource($_user);

        $_articles = $this->article_service->getArticleListByUser($id);
        $articles = ArticleResource::collection($_articles);

        return compact('user', 'articles');
    }

    /**
     * ユーザー編集画面
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * ユーザー更新処理
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, int $id)
    {
        // リクエスト
        $input = $request->only(['name', 'email']);
        $file = $request->file('image');

        // 更新
        $user = $this->user_service->updateUser($id, $input, $file);

        return new UserResource($user);
    }

    /**
     * ユーザー削除処理
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $this->user_service->deleteUser($id);
    }
}
