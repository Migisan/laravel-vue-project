<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\User;

class LoginUserApiTest extends TestCase
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
     * ログイン中のユーザーを返却する
     * 
     * @test
     * @return void
     */
    public function getLoginUser()
    {
        $response = $this->actingAs($this->user)->json('GET', route('login_user'));
        $response->dump();

        $response->assertStatus(200)->assertJson([
            'name' => $this->user->name,
        ]);
    }

    /**
     * ログイン中のユーザーがいない場合は空文字を返却する
     * 
     * @test
     * @return void
     */
    public function getNotLoginUser()
    {
        $response = $this->json('GET', route('login_user'));
        $response->dump();

        $response->assertStatus(200);
        $this->assertEquals("", $response->content());
    }
}
