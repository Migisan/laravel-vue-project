<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;

class LoginApiTest extends TestCase
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

        // テストユーザー生成
        $this->user = factory(User::class)->create();

        // 日時フォーマット
        $this->datetime_format = config('const.DATETIME_FORMAT');
    }

    /**
     * 登録済みのユーザーを認証して返却する
     * 
     * @test
     * @return void
     */
    public function loginAndReturnRegisteredUser(): void
    {
        // レスポンス
        $response = $this->json('POST', route('login'), [
            'email' => $this->user->email,
            'password' => 'password',
        ]);
        $response->dump();

        // 期待値
        $expected_structure = [
            'id',
            'name',
            'email',
            'image_path',
            'updated_at',
        ];
        $expected = [
            'id' => $this->user->id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'image_path' => $this->user->image_path,
            'updated_at' => $this->user->updated_at->format($this->datetime_format),
        ];

        // 検証
        $response->assertStatus(200)
            ->assertJsonStructure($expected_structure)
            ->assertExactJson($expected);
        $this->assertAuthenticatedAs($this->user);
    }
}
