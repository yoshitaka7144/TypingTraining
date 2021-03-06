<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table("users")->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $users = [
            [
                "name" => "admin",
                "password" => Hash::make("aaaa"),
                "role" => 2
            ],
            [
                "name" => "test2",
                "password" => Hash::make("bbbb"),
            ],
            [
                "name" => "test3",
                "password" => Hash::make("cccc"),
            ]
        ];

        // 登録
        foreach($users as $user){
            \App\User::create($user);
        }
    }
}
