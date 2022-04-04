<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Article;
use App\Models\Like;
use App\Models\User;

class ArticleDeleteLikeApiTest extends TestCase
{
    // テスト後のデータベースリセット
    use RefreshDatabase;

    private $user;

    private $article;

    private $like;

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
        $this->article = factory(Article::class)->create([
            'user_id' => $this->user->id,
        ]);

        // いいねデータ生成
        $this->like = factory(Like::class)->create([
            'article_id' => $this->article->id,
            'user_id' => $this->user->id,
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @test
     * @return void
     */
    public function deleteLike(): void
    {
        $response = $this->actingAs($this->user)
            ->json('POST', route('articles.deleteLike', $this->article->id));
        $response->dump();

        // 登録したデータ取得
        $like = Like::where('article_id', $this->article->id)
            ->where('user_id', $this->user->id)
            ->first();

        // 検証
        $response->assertStatus(200);
        $this->assertSame(0, Like::count());
        $this->assertNull($like);
    }
}
