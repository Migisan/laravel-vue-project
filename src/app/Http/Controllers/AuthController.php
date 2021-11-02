<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\User;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    /**
     * 会員登録
     * 
     * @param Request $request
     * @return User $user
     */
    public function register(RegisterRequest $request)
    {
        $user = new User();

        $user->fill($request->all())->save();

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

        if(Auth::attempt($credentials)) {
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
}
