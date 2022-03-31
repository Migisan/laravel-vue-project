<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Article;
use App\Models\Like;

class ArticleUpdateApiTest extends TestCase
{
    // テスト後のデータベースリセット
    use RefreshDatabase;

    private const LIKES_COUNT = 1;

    private $user;
    private $article;
    private $like;
    private $datetime_format;

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

        // いいねデータ生成
        $this->like = factory(Like::class, self::LIKES_COUNT)->create([
            'article_id' => $this->article->id,
            'user_id'    => $this->user->id,
        ]);

        // 日時フォーマット
        $this->datetime_format = config('const.DATETIME_FORMAT');
    }

    /**
     * 記事を更新する
     *
     * @test
     * @return void
     */
    public function updateArticle(): void
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
        $article = Article::find($this->article->id);

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
        $expected_data = [
            'id' => $article->id,
            'title' => $article->title,
            'body' => $article->body,
            'updated_at' => $article->updated_at->format($this->datetime_format),
            'user' => [
                'id' => $article->user->id,
                'name' => $article->user->name,
                'email' => $article->user->email,
                'image_path' => $article->user->image_path,
                'updated_at' => $article->user->updated_at->format($this->datetime_format),
            ],
            'likes_count' => self::LIKES_COUNT,
            'like_user_ids' => $article->likes->sortBy('user_id')->pluck('user_id'),
        ];

        // 検証
        $response->assertStatus(200)
            ->assertJsonStructure($expected_structure)
            ->assertExactJson($expected_data);
        $this->assertEquals($article->title, $data['title']);
        $this->assertEquals($article->body, $data['body']);
    }
}
