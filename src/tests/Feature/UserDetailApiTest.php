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

    /**
     * テスト前処理
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * ユーザーデータ詳細を取得する
     *
     * @test
     * @return void
     */
    public function getUser()
    {
        // ユーザーデータ生成
        $user = factory(User::class)->create();
        // 記事データ生成
        factory(Article::class, 10)->create();

        // レスポンス
        $response = $this->json('GET', route('users.show', $user->id));
        $response->dump();

        // 生成した記事データ取得
        $articles = Article::with(['user'])->orderBy('updated_at', 'desc')->get();

        // 検証
        $response
            ->assertStatus(200)
            ->assertJson([
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'articles' => $articles->only([
                    'id',
                    'title',
                    'body',
                    'updated_at',
                ])->toArray(),
            ]);
    }
}
