<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Article;
use App\Models\Comment;

class CommentListApiTest extends TestCase
{
    // テスト後のデータベースリセット
    use RefreshDatabase;

    private $article;
    private $comments;
    private $comment_data_count = 5;
    private $datetime_format;

    /**
     * テスト前処理
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        // 記事データ生成
        $this->article = factory(Article::class)->create();

        // コメントの生成
        $this->comments = factory(Comment::class, $this->comment_data_count)->create([
            'article_id' => $this->article->id,
        ]);

        // 日時フォーマット
        $this->datetime_format = config('const.DATETIME_FORMAT');
    }

    /**
     * コメント一覧を取得する
     *
     * @test
     * @return void
     */
    public function returnCommentListJson()
    {
        // データ
        $data = [
            'article_id' => $this->article->id,
        ];

        // レスポンス
        $response = $this->json('GET', route('comments.index'), $data);
        $response->dump();

        // データ取得
        $comments = Comment::with(['user'])
            ->where('article_id', $this->article->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // 期待値
        $expected_structure = [
            '*' => [
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
            ],
        ];
        $expected = $comments->map(function ($comment) {
            return [
                'id' => $comment->id,
                'article_id' => $comment->article_id,
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
        })->all();

        // 検証
        $response->assertStatus(200)
            // レスポンスのデータ構造が期待値と一致すること
            ->assertJsonStructure($expected_structure)
            // レスポンスが期待値と完全一致すること
            ->assertExactJson($expected);
    }
}
