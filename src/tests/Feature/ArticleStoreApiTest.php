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

    private $user;

    private $datetime_format;

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

        // 日時フォーマット
        $this->datetime_format = config('const.DATETIME_FORMAT');
    }

    /**
     * 記事を作成する
     * 
     * @test
     * @return void
     */
    public function createArticle(): void
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
            'likes_count' => 0,
            'like_user_ids' => [],
        ];

        // 検証
        $response->assertStatus(201)
            ->assertJsonStructure($expected_structure)
            ->assertExactJson($expected_data);
        $this->assertSame($article->title, $data['title']);
        $this->assertSame($article->body, $data['body']);
    }
}
