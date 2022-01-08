<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\User;

interface UserServiceInterface
{
  /**
   * 画像ファイルの保存
   * 
   * @param Request $request
   * @return string $path
   */
  public function saveImageFile(Request $request): string;

  /**
   * ユーザー更新
   * 
   * @param User $user
   * @param array $input
   * @return User $user
   */
  public function updateUser(User $user, array $input): User;

  /**
   * ユーザー更新
   * 
   * @param User $user
   * @return void
   */
  public function deleteUser(User $user): void;
}
