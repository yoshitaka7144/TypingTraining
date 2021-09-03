<?php

use Illuminate\Database\Seeder;
use App\History;

class HistoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // テーブルのクリア
        DB::table("histories")->truncate();

        $histories = [
            [
                "user_id" => 1,
                "category_id" => 1,
                "wpm" => 170,
                "correct_percentage" => 95,
                "miss_key" => "a,s,d",
            ],
            [
                "user_id" => 2,
                "category_id" => 2,
                "wpm" => 180,
                "correct_percentage" => 90,
                "miss_key" => "r,t",
            ],
            [
                "user_id" => 3,
                "category_id" => 3,
                "wpm" => 200,
                "correct_percentage" => 100,
                "miss_key" => "",
            ],
        ];

        // 登録
        foreach ($histories as $history) {
            \App\History::create($history);
        }
    }
}
