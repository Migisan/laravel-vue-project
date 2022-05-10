<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;

use App\Jobs\SendRegisterMailJob;

use App\Services\AuthServiceInterface;

use App\Models\User;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    /**
     * プロパティ
     */
    private $auth_service;

    /**
     * コンストラクタ
     */
    public function __construct(AuthServiceInterface $auth_service)
    {
        // DI
        $this->auth_service = $auth_service;
    }

    /**
     * 会員登録
     * 
     * @param Request $request
     * @return User $user
     */
    public function register(RegisterRequest $request)
    {
        // リクエスト
        $input = $request->only(['name', 'email', 'password']);
        $path = $request->file('image')->store('public/user');
        $input['image_path'] = '/storage/user/' . basename($path);
        $input['password'] = Hash::make($input['password']);

        DB::beginTransaction();
        try {
            // 登録
            $user = new User();
            $user->fill($input)->save();

            // メール送信
            SendRegisterMailJob::dispatch($user->name, $user->email);

            // ログイン
            Auth::login($user);

            DB::commit();

            return new UserResource($user);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * ログイン
     * 
     * @param Request $request
     * @return Auth
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // 認証成功
            $user = $this->auth_service->getAuth();

            return new UserResource($user);
        } else {
            // 認証失敗
            return $this->sendFailedLoginResponse($request);
        }
    }

    /**
     * ログイン画面表示(Google認証)
     * 
     * @param string $provider
     * @return Socialite
     */
    public function redirectToProvider(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * ログイン(Google認証)
     * 
     * @param Request $request
     * @param string $provider
     * @return Auth
     */
    public function handleProviderCallback(string $provider)
    {
        $providerUser = Socialite::driver($provider)->user();
        // $providerUser = Socialite::driver($provider)->stateless()->user();

        $user = User::where('email', $providerUser->getEmail())->first();

        if ($user) {
            Auth::login($user);
            return redirect('/');
        }
    }

    /**
     * ログアウト
     * 
     * @param Request $request
     * @return 
     */
    public function logout(Request $request)
    {
        // ログアウト
        Auth::logout();

        // セッションを再生成する
        $request->session()->regenerate();

        return response()->json();
    }

    /**
     * ログイン中のユーザー情報の取得
     * 
     * @param Request $request
     * @return ?\App\Models\User
     */
    public function login_user(Request $request)
    {
        $user = $this->auth_service->getAuth();

        if (isset($user)) {
            return new UserResource($user);
        }
    }

    /**
     * トークンをリフレッシュする
     */
    public function reflesh_token(Request $request)
    {
        $request->session()->regenerateToken();

        return response()->json();
    }
}
