<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\LikeResource;

use App\Services\LikeServiceInterface;

class LikeController extends Controller
{
    /**
     * プロパティ
     */
    private $like_service;

    /**
     * コンストラクタ
     */
    public function __construct(LikeServiceInterface $like_service)
    {
        // ミドルウェア
        $this->middleware('auth')->except(['index']);
        // DI
        $this->like_service = $like_service;
    }

    /**
     * いいね一覧
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $article_id = $request->article_id;

        $likes = $this->like_service->getLikeListByArticle($article_id);

        return LikeResource::collection($likes);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
