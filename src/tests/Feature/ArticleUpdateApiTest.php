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

        // 日時フォーマット
        $this->datetime_format = config('const.DATETIME_FORMAT');
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
        ];

        // 検証
        $response->assertStatus(200)
            ->assertJsonStructure($expected_structure)
            ->assertExactJson($expected_data);
        $this->assertEquals($article->title, $data['title']);
        $this->assertEquals($article->body, $data['body']);
    }
}
