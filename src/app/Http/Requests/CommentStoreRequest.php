<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentStoreRequest extends FormRequest
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
            'article_id' => 'required',
            'comment' => 'required',
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
            'article_id' => '記事ID',
            'comment' => 'コメント',
        ];
    }
}
