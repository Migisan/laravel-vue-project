<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Article;
use App\Models\User;
use App\Models\Like;

class ArticleListApiTest extends TestCase
{
    // テスト後のデータベースリセット
    use RefreshDatabase;

    private $article_data_count;
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
        factory(User::class, 3)->create();

        // 記事データ生成
        $this->article_data_count = 5;
        factory(Article::class, $this->article_data_count)->create();

        // いいねデータ生成
        factory(Like::class, 10)->create();

        // 日時フォーマット
        $this->datetime_format = config('const.DATETIME_FORMAT');
    }

    /**
     * 記事一覧のJSONデータを返却する
     * 
     * @test
     * @return void
     */
    public function returnArticleListJson(): void
    {
        // レスポンス
        $response = $this->json('GET', route('articles.index'));
        $response->dump();

        // データ取得
        $articles = Article::with(['user', 'likes'])->orderBy('updated_at', 'desc')->get();

        // 期待値
        $expected_data_count = $this->article_data_count;
        $expected_structure = [
            'data' => [
                '*' => [
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
                ],
            ],
            'links' => [
                'first',
                'last',
                'next',
                'prev',
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'path',
                'per_page',
                'to',
                'total',
            ],
        ];
        $expected_data = $articles->map(function ($article) {
            return [
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
                'likes_count' => $article->likes->count(),
            ];
        })->all();
        $expected_links = [
            'first' => url('/api/articles?page=1'),
            'last' => url('/api/articles?page=1'),
            'next' => null,
            'prev' => null,
        ];
        $expected_meta = [
            'current_page' => 1,
            'from' => 1,
            'last_page' => 1,
            'path' => url('/api/articles'),
            'per_page' => config('const.PER_PAGE'),
            'to' => 5,
            'total' => 5,
        ];

        // 検証
        $response->assertStatus(200)
            // レスポンスのdata項目に含まれる要素が5つであること
            ->assertJsonCount($expected_data_count, 'data')
            // レスポンスのデータ構造が期待値と一致すること
            ->assertJsonStructure($expected_structure)
            // レスポンスが期待値と完全一致すること
            ->assertExactJson([
                'data' => $expected_data,
                'links' => $expected_links,
                'meta' => $expected_meta,
            ]);
    }
}
