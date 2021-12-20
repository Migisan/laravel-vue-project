<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\User;

class LogoutApiTest extends TestCase
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

        // テストユーザーの作成
        $this->user = factory(User::class)->create();
    }

    /**
     * 認証済みのユーザーをログアウトする
     * 
     * @test
     * @return void
     */
    public function logoutAuthenticatedUser()
    {
        // レスポンス
        $response = $this->actingAs($this->user)->json('POST', route('logout'));
        $response->dump();

        // 検証
        $response->assertStatus(200);
        $this->assertGuest();
    }
}
