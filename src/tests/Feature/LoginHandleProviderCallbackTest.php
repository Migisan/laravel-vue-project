<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;

use Mockery;
use Laravel\Socialite\Facades\Socialite;

class LoginHandleProviderCallbackTest extends TestCase
{
    // テスト後のデータベースリセット
    use RefreshDatabase;

    private $user;
    private $datetime_format;
    private $provider;

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

    private function createSocialUser(string $email): void
    {
        // 初期設定
        Mockery::getConfiguration()->allowMockingNonExistentMethods(false);

        // ユーザー作成
        $socialUser = Mockery::mock('Laravel\Socialite\Two\User');
        $socialUser->shouldReceive('getId')
            ->andReturn(uniqid())
            ->shouldReceive('getEmail')
            ->andReturn($email)
            ->shouldReceive('getNickname')
            ->andReturn('testman');

        $this->provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $this->provider->shouldReceive('user')->andReturn($socialUser);
    }

    /**
     * プロバイダーでユーザーを認証して返却する
     * 
     * @test
     * @return void
     */
    public function ProviderLoginAndReturnRegisteredUser(): void
    {
        $this->createSocialUser($this->user->email);
        Socialite::shouldReceive('driver')->with('google')->once()->andReturn($this->provider);

        // レスポンス
        $response = $this->json('GET', route('login.{provider}.callback', ['provider' => 'google']));
        $response->dump();

        // 検証
        $response->assertStatus(302);
        $this->assertAuthenticatedAs($this->user);
    }
}
