<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 外部キー制約の解除
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // 全シーダー実行
        $this->call([
            UserSeeder::class,
            ArticleSeeder::class,
        ]);

        // 外部キー制約の設定
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
