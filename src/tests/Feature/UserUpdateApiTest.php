<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class UserUpdateApiTest extends TestCase
{
    // テスト後のデータベースリセット
    use RefreshDatabase;

    private $user;
    private $file;
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

        // 画像ファイルの生成
        $this->file = UploadedFile::fake()->image('test.jpg');

        // 日時フォーマット
        $this->datetime_format = config('const.DATETIME_FORMAT');
    }

    /**
     * ユーザーを更新する
     *
     * @test
     * @return void
     */
    public function updateUser(): void
    {
        // データ
        $data = [
            'name' => 'update user',
            'email' => 'update_user@example.com',
            'image' => $this->file,
        ];

        // レスポンス
        $response = $this->actingAs($this->user)
            ->patchJson(route('users.update', $this->user->id), $data);
        $response->dump();

        // 更新したデータ取得
        $user = User::find($this->user->id);

        // 期待値
        $expected_structure = [
            'id',
            'name',
            'email',
            'image_path',
            'updated_at',
        ];
        $expected = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'image_path' => $user->image_path,
            'updated_at' => $user->updated_at->format($this->datetime_format),
        ];

        // 検証
        $response->assertStatus(200)
            ->assertJsonStructure($expected_structure)
            ->assertExactJson($expected);
        $this->assertSame($user->name, $data['name']);
        $this->assertSame($user->email, $data['email']);
        Storage::disk('public')->assertExists('/user/' . $this->file->hashName());

        // 画像ファイルの削除
        Storage::disk('public')->delete('/user/' . $this->file->hashName());
    }
}
