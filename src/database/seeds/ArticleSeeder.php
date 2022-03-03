<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use App\Models\Article;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB初期化
        DB::table('articles')->truncate();

        // ダミーデータ
        factory(Article::class, 50)->create();
    }
}
