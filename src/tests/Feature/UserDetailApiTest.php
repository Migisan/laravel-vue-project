<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Article;
use App\Models\User;

class UserDetailApiTest extends TestCase
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

        // ユーザーデータ生成
        $users = factory(User::class, 3)->create();
        $this->user = $users->first();

        // 記事データ生成
        foreach ($users as $user) {
            factory(Article::class, 3)->create([
                'user_id' => $user->id,
            ]);
        }

        // 日時フォーマット
        $this->datetime_format = config('const.DATETIME_FORMAT');
    }

    /**
     * ユーザーデータ詳細を取得する
     *
     * @test
     * @return void
     */
    public function getUser(): void
    {
        // レスポンス
        $response = $this->json('GET', route('users.show', $this->user->id));
        $response->dump();

        // 生成した記事データ取得
        $articles = Article::with(['user'])
            ->where('user_id', $this->user->id)
            ->orderBy('updated_at', 'desc')
            ->get();

        // 期待値
        $expected_structure = [
            'user' => [
                'id',
                'name',
                'email',
                'image_path',
                'updated_at',
            ],
            'articles' => [
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
                ],
            ],
        ];
        $expected_user = [
            'id' => $this->user->id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'image_path' => $this->user->image_path,
            'updated_at' => $this->user->updated_at->format($this->datetime_format),
        ];
        $expected_articles = $articles->map(function ($article) {
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
            ];
        })->all();

        // 検証
        $response->assertStatus(200)
            ->assertJsonStructure($expected_structure)
            ->assertExactJson([
                'user' => $expected_user,
                'articles' => $expected_articles,
            ]);
    }
}
