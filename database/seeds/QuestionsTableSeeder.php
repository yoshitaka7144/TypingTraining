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
                "category" => "aaa",
                "text" => "なんかテスト問題",
                "kana" => "なんかてすともんだい",
                "roman" => "nankatesutomondai",
            ],
            [
                "category" => "bbb",
                "text" => "墾田永年私財法",
                "kana" => "こんでんえいねんしざいほう",
                "roman" => "kondeneinensizaihou",
            ],
            [
                "category" => "aaa",
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
