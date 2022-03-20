<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Article;
use App\Models\User;

class ArticleUpdateApiTest extends TestCase
{
    // テスト後のデータベースリセット
    use RefreshDatabase;

    private $user;
    private $article;

    /**
     * テスト前処理
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        // テストユーザー生成
        $this->user = factory(User::class)->create();

        // 記事データ生成
        $this->article = factory(Article::class)->create();
    }

    /**
     * 記事を更新する
     *
     * @test
     * @return void
     */
    public function updateArticle()
    {
        // データ
        $data = [
            'title' => 'テストタイトル',
            'body' => 'テスト本文',
        ];

        // レスポンス
        $response = $this->actingAs($this->user)
            ->patchJson(route('articles.update', $this->article->id), $data);
        $response->dump();

        // 更新したデータ取得
        $after_article = Article::find($this->article->id);

        // 検証
        $response->assertStatus(200);
        $this->assertEquals($after_article->title, $data['title']);
        $this->assertEquals($after_article->body, $data['body']);
    }
}
