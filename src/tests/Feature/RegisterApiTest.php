<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\User;

class RegisterApiTest extends TestCase
{
    // テスト後のデータベースリセット
    use RefreshDatabase;

    /**
     * 新しいユーザーを作成して返却する
     * 
     * @test
     * @return void
     */
    public function createAndReturnNewUser()
    {
        // データ
        $data = [
            'name' => 'new user',
            'email' => 'new_user@example.com',
            'password' => 'test1234',
            'password_confirmation' => 'test1234',
        ];

        // レスポンス
        $response = $this->json('POST', route('register'), $data);
        $response->dump();

        // 登録したデータ取得
        $user = User::first();

        // 検証
        $this->assertEquals($data['name'], $user->name);
        $response->assertStatus(201)->assertJson(['name' => $user->name]);
    }
}
