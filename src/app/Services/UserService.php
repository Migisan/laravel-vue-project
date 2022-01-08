<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Services\UserServiceInterface;
use App\Repositories\UserRepositoryInterface;
use App\User;

class UserService implements UserServiceInterface
{
  private $user_repository;

  /**
   * コンストラクタ
   */
  public function __construct(UserRepositoryInterface $user_repository)
  {
    // DI
    $this->user_repository = $user_repository;
  }

  /**
   * 画像ファイルの保存
   * 
   * @param Request $request
   * @return string $path
   */
  public function saveImageFile(Request $request): string
  {
    $path = $request->file('image')->store('public/user');

    return $path;
  }

  /**
   * ユーザー更新
   * 
   * @param User $user
   * @param array $input
   * @return User $user
   */
  public function updateUser(User $user, array $input): User
  {
    $user = $this->user_repository->updateUser($user, $input);

    return $user;
  }

  /**
   * ユーザー更新
   * 
   * @param User $user
   * @return void
   */
  public function deleteUser(User $user): void
  {
    $user->delete();
  }
}
