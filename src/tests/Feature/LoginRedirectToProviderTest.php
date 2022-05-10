<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use Illuminate\Support\Facades\App;

class LoginRedirectToProviderTest extends TestCase
{
    /**
     * テスト前処理
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * プロバイダー認証画面へリダイレクトする
     * 
     * @test
     * @return void
     */
    public function redirectToProvider(): void
    {
        // レスポンス
        $response = $this->json('GET', route('login.{provider}', ['provider' => 'google']));
        $response->dump();

        // 検証
        $response->assertStatus(302);

        $target = parse_url($response->headers->get('location'));
        $this->assertSame('accounts.google.com', $target['host']);

        $query = explode('&', $target['query']);
        $this->assertContains('redirect_uri=' . urlencode(config('services.google.redirect')), $query);
        $this->assertContains('client_id=' . config('services.google.client_id'), $query);
    }
}
