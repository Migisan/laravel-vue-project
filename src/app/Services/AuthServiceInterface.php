<?php

namespace App\Services;

interface AuthServiceInterface
{
  /**
   * ログイン中のユーザー取得
   * 
   * @return ?\App\Models\User $user
   */
  public function getAuth(): ?\App\Models\User;
}
