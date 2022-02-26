<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Article;
use App\Models\User;

class ArticleStoreApiTest extends TestCase
{
    // テスト後のデータベースリセット
    use RefreshDatabase;

    /**
     * テスト前処理
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        // テストユーザーの作成
        $this->user = factory(User::class)->create();
    }

    /**
     * 記事を作成する
     * 
     * @test
     * @return void
     */
    public function createArticle()
    {
        // データ
        $data = [
            'title' => 'テストタイトル',
            'body' => 'テスト本文',
        ];

        // レスポンス
        $response = $this->actingAs($this->user)
            ->json('POST', route('articles.store'), $data);
        $response->dump();

        // 登録したデータ取得
        $article = Article::first();

        // 検証
        $response->assertStatus(201);
        $this->assertEquals($article->title, $data['title']);
    }
}
