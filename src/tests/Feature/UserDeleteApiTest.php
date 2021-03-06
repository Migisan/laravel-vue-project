<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;

class UserDeleteApiTest extends TestCase
{
    // テスト後のデータベースリセット
    use RefreshDatabase;

    private $user;

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
    }

    /**
     * ユーザーを削除する
     *
     * @test
     * @return void
     */
    public function deleteUser(): void
    {
        // レスポンス
        $response = $this->actingAs($this->user)
            ->deleteJson(route('users.destroy', $this->user->id));
        dump($response);

        // 検証
        $response->assertStatus(200);
        $this->assertSame(0, User::count());
    }
}
