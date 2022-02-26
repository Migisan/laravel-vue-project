<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Article;
use App\Models\User;

class ArticleDeleteApiTest extends TestCase
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
     * 記事を削除する
     *
     * @test
     * @return void
     */
    public function deleteArticle()
    {
        // 記事データ生成
        $article = factory(Article::class)->create();

        // レスポンス
        $response = $this->actingAs($this->user)
            ->deleteJson(route('articles.destroy', $article->id));
        dump($response);

        // 検証
        $response->assertStatus(200);
        $this->assertEquals(0, Article::count());
    }
}
