<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Article;
use App\Models\Comment;

class CommentStoreApiTest extends TestCase
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

        // ユーザーの生成
        $this->user = factory(User::class)->create();

        // 記事の生成
        $this->article = factory(Article::class)->create();

        // 日時フォーマット
        $this->datetime_format = config('const.DATETIME_FORMAT');
    }

    /**
     * コメントを登録する
     *
     * @test
     * @return void
     */
    public function createComment()
    {
        // データ
        $data = [
            'article_id' => $this->article->id,
            'comment' => 'テストコメント',
        ];

        // レスポンス
        $response = $this->actingAs($this->user)
            ->json('POST', route('comments.store'), $data);
        $response->dump();

        // 登録したコメント取得
        $comment = Comment::first();

        // 期待値
        $expected_structure = [
            'id',
            'article_id',
            'comment',
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
            'id' => $comment->id,
            'article_id' => $this->article->id,
            'comment' => $comment->comment,
            'updated_at' => $comment->updated_at->format($this->datetime_format),
            'user' => [
                'id' => $comment->user->id,
                'name' => $comment->user->name,
                'email' => $comment->user->email,
                'image_path' => $comment->user->image_path,
                'updated_at' => $comment->user->updated_at->format($this->datetime_format),
            ],
        ];

        // 検証
        $response->assertStatus(201)
            ->assertJsonStructure($expected_structure)
            ->assertExactJson($expected_data);
    }
}
