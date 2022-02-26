<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;

use App\Repositories\UserRepositoryInterface;

use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
  /**
   * ログイン中ユーザー取得
   * 
   * @return ?User
   */
  public function getAuth(): ?User
  {
    return Auth::user();
  }

  /**
   * ユーザー取得
   * 
   * @param int $id
   * @return User
   */
  public function find($id): User
  {
    return User::find($id);
  }

  /**
   * ユーザー更新
   * 
   * @param int $id
   * @param array $params
   * @return User $user
   */
  public function update(int $id, array $params): User
  {
    $user = User::find($id);

    $user->fill($params)->save();

    return $user;
  }

  /**
   * ユーザー削除
   * 
   * @param int $id
   * @return void
   */
  public function delete(int $id): void
  {
    $user = User::find($id);

    $user->delete();
  }
}
