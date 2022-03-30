<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Article;
use App\Models\Like;
use App\Models\User;

class ArticleAddLikeApiTest extends TestCase
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

        // ユーザー生成
        $this->user = factory(User::class)->create();

        // 記事データ生成
        $this->article = factory(Article::class)->create();
    }

    /**
     * A basic feature test example.
     *
     * @test
     * @return void
     */
    public function addLike(): void
    {
        $response = $this->actingAs($this->user)
            ->json('POST', route('articles.addLike', $this->article->id));
        $response->dump();

        // 登録したデータ取得
        $like = Like::first();

        // 検証
        $response->assertStatus(200);
        $this->assertEquals($like->article_id, $this->article->id);
        $this->assertEquals($like->user_id, $this->user->id);
    }
}
