<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\User;

class LoginApiTest extends TestCase
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
     * 登録済みのユーザーを認証して返却する
     * 
     * @test
     * @return void
     */
    public function loginAndReturnRegisteredUser()
    {
        $response = $this->json('POST', route('login'), [
            'email' => $this->user->email,
            'password' => 'password',
        ]);
        $response->dump();

        $response->assertStatus(200)->assertJson(['name' => $this->user->name]);

        $this->assertAuthenticatedAs($this->user);
    }
}
