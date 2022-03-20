<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class RegisterApiTest extends TestCase
{
    // テスト後のデータベースリセット
    use RefreshDatabase;

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

        // 画像ファイルの生成
        $this->file = UploadedFile::fake()->image('test.jpg');

        // 日時フォーマット
        $this->datetime_format = config('const.DATETIME_FORMAT');
    }

    /**
     * 新しいユーザーを作成して返却する
     * 
     * @test
     * @return void
     */
    public function createAndReturnNewUser(): void
    {
        // データ
        $data = [
            'name' => 'new user',
            'email' => 'new_user@example.com',
            'image' => $this->file,
            'password' => 'test1234',
            'password_confirmation' => 'test1234',
        ];

        // レスポンス
        $response = $this->json('POST', route('register'), $data);
        $response->dump();

        // 登録したデータ取得
        $user = User::first();

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
        $response->assertStatus(201)
            ->assertJsonStructure($expected_structure)
            ->assertExactJson($expected);
        $this->assertSame($data['name'], $user->name);
        $this->assertSame($data['email'], $user->email);
        Storage::disk('public')->assertExists('/user/' . $this->file->hashName());

        // 画像ファイルの削除
        Storage::disk('public')->delete('/user/' . $this->file->hashName());
    }
}
