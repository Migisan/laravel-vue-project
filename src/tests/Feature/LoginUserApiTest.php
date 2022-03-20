<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;

class LoginUserApiTest extends TestCase
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
     * ログイン中のユーザーを返却する
     * 
     * @test
     * @return void
     */
    public function getLoginUser(): void
    {
        // レスポンス
        $response = $this->actingAs($this->user)->json('GET', route('login_user'));
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
    }

    /**
     * ログイン中のユーザーがいない場合は空文字を返却する
     * 
     * @test
     * @return void
     */
    public function getNotLoginUser(): void
    {
        // レスポンス
        $response = $this->json('GET', route('login_user'));
        $response->dump();

        // 検証
        $response->assertStatus(200);
        $this->assertSame("", $response->content());
    }
}
