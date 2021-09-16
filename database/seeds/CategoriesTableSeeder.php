<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // テーブルのクリア
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table("categories")->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $categories = [
            [
                "name" => "50音",
                "description" => "あいうえお...わをん、濁音、拗音が出題されます。日本語入力の基礎練習が行えます。",
            ],
            [
                "name" => "bbb",
                "description" => "",
            ],
            [
                "name" => "ccc",
            ]
        ];

        // 登録
        foreach ($categories as $category) {
            \App\Category::create($category);
        }
    }
}
