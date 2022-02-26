<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

interface UserServiceInterface
{
  /**
   * ユーザー取得
   * 
   * @param int $id
   * @return \App\Models\User $user
   */
  public function findUser(int $id): \App\Models\User;

  /**
   * ユーザー更新
   * 
   * @param int $id
   * @param array $input
   * @return \App\Models\User $user
   */
  public function updateUser(int $id, array $input, UploadedFile $file): \App\Models\User;

  /**
   * ユーザー削除
   * 
   * @param int $id
   * @return void
   */
  public function deleteUser(int $id): void;
}
