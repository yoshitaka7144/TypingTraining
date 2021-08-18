<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // テーブルのクリア
        DB::table("users")->truncate();

        $users = [
            [
                "name" => "admin",
                "password" => "aaaa",
                "role" => 2
            ],
            [
                "name" => "test2",
                "password" => "bbbb",
            ],
            [
                "name" => "test3",
                "password" => "cccc",
            ]
        ];

        // 登録
        foreach($users as $user){
            \App\User::create($user);
        }
    }
}
