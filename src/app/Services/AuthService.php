<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

use App\Services\AuthServiceInterface;

use App\Repositories\UserRepositoryInterface;

class AuthService implements AuthServiceInterface
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
   * ログイン中のユーザー取得
   * 
   * @return ?\App\Models\User $user
   */
  public function getAuth(): ?\App\Models\User
  {
    $user = $this->user_repository->getAuth();

    return $user;
  }
}
