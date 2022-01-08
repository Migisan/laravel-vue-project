<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\UserServiceInterface;
use App\Services\ArticleServiceInterface;
use App\Http\Requests\UserUpdateRequest;
use App\User;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $articles = $this->article_service->getArticleListByUser($user->id);

        return compact('user', 'articles');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        // リクエスト取得
        $input = $request->all();

        // 画像
        if ($request->file('image')) {
            // 画像保存
            $path = $this->user_service->saveImageFile($request);
            $input['image_path'] = '/storage/user/' . basename($path);
        }

        // 更新
        $user = $this->user_service->updateUser($user, $input);

        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->user_service->deleteUser($user);
    }
}
