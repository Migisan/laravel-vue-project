<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

use App\Services\UserServiceInterface;

use App\Repositories\UserRepositoryInterface;

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
   * ユーザー取得
   * 
   * @param int $id
   * @return \App\Models\User $user
   */
  public function findUser(int $id): \App\Models\User
  {
    $user = $this->user_repository->find($id);

    return $user;
  }

  /**
   * ユーザー更新
   * 
   * @param int $id
   * @param array $input
   * @return \App\Models\User $user
   */
  public function updateUser(int $id, array $input, UploadedFile $file): \App\Models\User
  {
    // 画像
    if (isset($file)) {
      $path = $file->store('public/user');
      $input['image_path'] = '/storage/user/' . basename($path);
    }

    // 更新
    $user = $this->user_repository->update($id, $input);

    return $user;
  }

  /**
   * ユーザー削除
   * 
   * @param int $id
   * @return void
   */
  public function deleteUser(int $id): void
  {
    $this->user_repository->delete($id);
  }
}
