<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;

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
        $user = new User();

        // 登録
        $input = $request->only(['name', 'email', 'password']);
        $path = $request->file('image')->store('public/user');
        $input['image_path'] = '/storage/user/' . basename($path);
        $input['password'] = Hash::make($input['password']);
        $user->fill($input)->save();

        // ログイン
        Auth::login($user);

        return $user;
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
            return Auth::user();
        } else {
            // 認証失敗
            return $this->sendFailedLoginResponse($request);
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

        return $user;
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
