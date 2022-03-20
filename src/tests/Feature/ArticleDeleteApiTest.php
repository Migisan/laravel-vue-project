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
     * 記事を削除する
     *
     * @test
     * @return void
     */
    public function deleteArticle(): void
    {
        // レスポンス
        $response = $this->actingAs($this->user)
            ->deleteJson(route('articles.destroy', $this->article->id));
        dump($response);

        // 検証
        $response->assertStatus(200);
        $this->assertEquals(0, Article::count());
    }
}
