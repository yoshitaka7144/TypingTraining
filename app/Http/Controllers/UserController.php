<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

/**
 * ユーザーコントローラー
 */
class UserController extends Controller
{
    /**
     * ユーザーデータ更新
     *
     * @param Request $request
     * @param User $user
     * @return void
     */
    public function update(Request $request, User $user)
    {
        // タイプ回数を更新
        $user->type_count += $request->typeCount;
        $user->save();

        return $user;
    }

    /**
     * ユーザーデータ取得
     *
     * @param User $user
     * @return void
     */
    public function show(User $user)
    {
        return $user;
    }

}
