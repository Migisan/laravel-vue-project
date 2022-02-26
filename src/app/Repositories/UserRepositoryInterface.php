<?php

namespace App\Repositories;

use App\Models\User;

interface UserRepositoryInterface
{
  /**
   * ログイン中ユーザー取得
   * 
   * @return ?User $user
   */
  public function getAuth(): ?User;

  /**
   * ユーザー取得
   * 
   * @param int $id
   * @return User
   */
  public function find($id): User;

  /**
   * ユーザー更新
   * 
   * @param int $id
   * @param array $params
   * @return User $user
   */
  public function update(int $id, array $params): User;

  /**
   * ユーザー削除
   * 
   * @param int $id
   * @return void
   */
  public function delete(int $id): void;
}
