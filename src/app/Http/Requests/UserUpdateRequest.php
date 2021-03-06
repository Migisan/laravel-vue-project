<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => '',
            // 'email' => 'email:strict,dns',
            'email' => 'email:strict',
            'image' => 'file',
            // 'password' => 'required|confirmed',
            // 'password_confirmation' => 'required',
        ];
    }

    /**
     * バリデーションエラーのカスタム属性の取得
     * 
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => '名前',
            'email' => 'メールアドレス',
            'image' => 'プロフィール画像',
            // 'password' => 'パスワード',
            // 'password_confirmation' => '確認用パスワード',
        ];
    }
}
