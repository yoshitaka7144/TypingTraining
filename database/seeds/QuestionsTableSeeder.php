<?php

use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // テーブルのクリア
        DB::table("questions")->truncate();

        $questions = [
            [
                "category_id" => 1,
                "text" => "なんかテスト問題",
                "kana" => "なんかてすともんだい",
                "roman" => "nankatesutomondai",
            ],
            [
                "category_id" => 2,
                "text" => "墾田永年私財法",
                "kana" => "こんでんえいねんしざいほう",
                "roman" => "kondeneinensizaihou",
            ],
            [
                "category_id" => 3,
                "text" => "札幌",
                "kana" => "さっぽろ",
                "roman" => "sapporo",
            ]
        ];

        // 登録
        foreach ($questions as $question) {
            \App\Question::create($question);
        }
    }
}
