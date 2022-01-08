<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\User;

class UserUpdateApiTest extends TestCase
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
     * ユーザーを更新する
     *
     * @test
     * @return void
     */
    public function updateUser()
    {
        // 画像ファイルの生成
        $file = UploadedFile::fake()->image('test.jpg');

        // データ
        $data = [
            'name' => 'update user',
            'email' => 'update_user@example.com',
            'image' => $file,
        ];

        // レスポンス
        $response = $this->actingAs($this->user)
            ->patchJson(route('users.update', $this->user->id), $data);
        $response->dump();

        // 更新したデータ取得
        $after_user = User::find($this->user->id);

        // 検証
        $response->assertStatus(200);
        $this->assertEquals($after_user->name, $data['name']);
        $this->assertEquals($after_user->email, $data['email']);
        Storage::disk('public')->assertExists('/user/' . $file->hashName());

        // 画像ファイルの削除
        Storage::disk('public')->delete('/user/' . $file->hashName());
    }
}
