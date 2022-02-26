<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Article;
use App\Models\User;

class ArticleListApiTest extends TestCase
{
    // テスト後のデータベースリセット
    use RefreshDatabase;

    /**
     * テスト前処理
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        // 日付フォーマット
        $this->dataFormat = 'Y-m-d H:i:s';

        // テストユーザーの作成
        $this->user = factory(User::class)->create();
    }

    /**
     * 記事一覧のJSONデータを返却する
     * 
     * @test
     * @return void
     */
    public function returnArticleListJson()
    {
        // 記事データ生成
        factory(Article::class, 5)->create();

        // レスポンス
        $response = $this->json('GET', route('articles.index'));
        $response->dump();

        // 生成したデータ取得
        $articles = Article::with(['user'])->orderBy('created_at', 'desc')->get();

        // 期待値
        $expected_data = $articles->map(function ($article) {
            return [
                'id' => $article->id,
                'title' => $article->title,
                'body' => $article->body,
                'user_id' => $article->user_id,
                'created_at' => $article->created_at->format($this->dataFormat),
                'updated_at' => $article->updated_at->format($this->dataFormat),
                'deleted_at' => null,
                'user' => [
                    'id' => $article->user->id,
                    'name' => $article->user->name,
                    'email' => $article->user->email,
                    'image_path' => $article->user->image_path,
                    'created_at' => $article->user->created_at->format($this->dataFormat),
                    'updated_at' => $article->user->updated_at->format($this->dataFormat),
                    'deleted_at' => null,
                ]
            ];
        })->all();
        dump($expected_data);

        // 検証
        $response->assertStatus(200)
            // レスポンスのdata項目に含まれる要素が5つであること
            ->assertJsonCount(5, 'data')
            // レスポンスのdata項目が期待値と一致こと
            ->assertJsonFragment([
                'data' => $expected_data,
            ]);
    }
}
