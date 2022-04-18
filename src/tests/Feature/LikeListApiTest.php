<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Article;
use App\Models\User;
use App\Models\Like;

class LikeListApiTest extends TestCase
{
    // テスト後のデータベースリセット
    use RefreshDatabase;

    private $article;
    private $like_data_count = 5;
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

        // いいねデータ生成
        factory(Like::class, $this->like_data_count)->create([
            'article_id' => $this->article->id,
        ]);

        // 日時フォーマット
        $this->datetime_format = config('const.DATETIME_FORMAT');
    }

    /**
     * いいね一覧のJSONデータを返却する
     *
     * @test
     * @return void
     */
    public function returnLikeListJson(): void
    {
        // データ
        $data = [
            'article_id' => $this->article->id,
        ];

        // レスポンス
        $response = $this->json('GET', route('likes.index'), $data);
        $response->dump();

        // データ取得
        $likes = Like::with(['user'])
            ->where('article_id', $this->article->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // 期待値
        $expected_data_count = $this->like_data_count;
        $expected_structure = [
            '*' => [
                'user' => [
                    'id',
                    'name',
                    'email',
                    'image_path',
                    'updated_at',
                ],
                'created_at',
            ],
        ];
        $expected = $likes->map(function ($like) {
            return [
                'user' => [
                    'id' => $like->user->id,
                    'name' => $like->user->name,
                    'email' => $like->user->email,
                    'image_path' => $like->user->image_path,
                    'updated_at' => $like->user->updated_at->format($this->datetime_format),
                ],
                'created_at' => $like->created_at->format($this->datetime_format),
            ];
        })->all();

        // 検証
        $response->assertStatus(200)
            // レスポンスのデータ構造が期待値と一致すること
            ->assertJsonStructure($expected_structure)
            // レスポンスが期待値と完全一致すること
            ->assertExactJson($expected);

        $this->assertEquals($this->like_data_count, Like::count());
    }
}
