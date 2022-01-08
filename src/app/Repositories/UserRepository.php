<?php

namespace App\Repositories;

use App\Repositories\UserRepositoryInterface;
use App\User;

class UserRepository implements UserRepositoryInterface
{
  /**
   * ユーザー更新
   * 
   * @param User $user
   * @param array $input
   * @return User $user
   */
  public function updateUser(User $user, array $input): User
  {
    $user->fill($input)->save();

    return $user;
  }
}
