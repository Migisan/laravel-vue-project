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
    private $datetime_format;

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

        // 日時フォーマット
        $this->datetime_format = config('const.DATETIME_FORMAT');
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

        // 期待値
        $expected_structure = [
            'id',
            'title',
            'body',
            'updated_at',
            'user' => [
                'id',
                'name',
                'email',
                'image_path',
                'updated_at',
            ],
            'likes_count',
            'like_user_ids',
        ];
        $expected_article = [
            'id' => $this->article->id,
            'title' => $this->article->title,
            'body' => $this->article->body,
            'updated_at' => $this->article->updated_at->format($this->datetime_format),
            'user' => [
                'id' => $this->article->user->id,
                'name' => $this->article->user->name,
                'email' => $this->article->user->email,
                'image_path' => $this->article->user->image_path,
                'updated_at' => $this->article->user->updated_at->format($this->datetime_format),
            ],
            'likes_count' => $this->article->likes->count(),
            'like_user_ids' => $this->article->likes->sortBy('user_id')->pluck('user_id'),
        ];

        // 登録したデータ取得
        $like = Like::first();

        // 検証
        $response->assertStatus(200)
            ->assertJsonStructure($expected_structure)
            ->assertExactJson($expected_article);
        $this->assertEquals($like->article_id, $this->article->id);
        $this->assertEquals($like->user_id, $this->user->id);
    }
}
