<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

        // データ登録
        DB::table('users')->insert(array(
            [
                'id'         => 1,
                'name'       => 'test',
                'email'      => 'test@example.com',
                'password'   => Hash::make('password'),
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
        ));
    }
}
