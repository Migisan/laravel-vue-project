<?php

namespace App\Repositories;

use App\User;

interface UserRepositoryInterface
{
  /**
   * ユーザー更新
   * 
   * @param User $user
   * @param array $input
   * @return User $user
   */
  public function updateUser(User $user, array $input): User;
}
