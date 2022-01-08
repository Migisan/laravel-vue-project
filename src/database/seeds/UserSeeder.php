<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB初期化
        DB::table('users')->truncate();

        // 初期データ
        DB::table('users')->insert(array(
            [
                'id'         => 1,
                'name'       => 'test',
                'email'      => 'test@example.com',
                'image_path' => '/storage/user/test.png',
                'password'   => Hash::make('password'),
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
        ));

        // ダミーデータ
        factory(User::class, 10)->create();
    }
}
