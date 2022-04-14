<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Article;
use App\Models\User;
use App\Models\Like;

class ArticleDetailApiTest extends TestCase
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

        // ユーザーデータ生成
        $this->user = factory(User::class)->create();

        // 記事データ生成
        $this->article = factory(Article::class)->create([
            'user_id' => $this->user->id,
        ]);

        // いいねデータ生成
        factory(Like::class)->create([
            'article_id' => $this->article->id,
        ]);

        // 日時フォーマット
        $this->datetime_format = config('const.DATETIME_FORMAT');
    }

    /**
     * 記事詳細を取得する
     *
     * @test
     * @return void
     */
    public function getArticle()
    {
        // レスポンス
        $response = $this->json('GET', route('articles.show', $this->article->id));
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
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
                'image_path' => $this->user->image_path,
                'updated_at' => $this->user->updated_at->format($this->datetime_format),
            ],
            'likes_count' => $this->article->likes->count(),
            'like_user_ids' => $this->article->likes->sortBy('user_id')->pluck('user_id'),
        ];

        // 検証
        $response->assertStatus(200)
            ->assertJsonStructure($expected_structure)
            ->assertExactJson($expected_article);
    }
}
