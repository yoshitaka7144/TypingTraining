<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\History;

/**
 * 履歴コントローラー
 */
class HistoryController extends Controller
{
    /**
     * 履歴データ取得
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $user_id = $request->userId;
        $category_id = $request->categoryId;
        if (isset($user_id) && isset($category_id)) {
            // ユーザーIDとカテゴリーID指定で取得
            return History::where("user_id", $user_id)->where("category_id", $category_id)->orderBy("created_at", "desc")->paginate($request->perPage);
        } else if (isset($user_id) && !isset($category_id)) {
            // ユーザーIDのみ指定で取得
            return History::select("categories.name as category", "wpm", "correct_percentage", "miss_key", "histories.created_at as created_at")->join("categories", "categories.id", "=", "histories.category_id")->where("user_id", $user_id)->orderBy("created_at", "desc")->paginate($request->perPage);
        } else {
            return false;
        }
    }

    /**
     * 履歴データ登録
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $history = new History();
        $history->user_id = $request->userId;
        $history->category_id = $request->categoryId;
        $history->wpm = $request->wpm;
        $history->correct_percentage = $request->correctPercentage;
        $history->miss_key = $request->missKey;
        $history->save();

        return $history;
    }

    /**
     * wpmの平均値を取得
     *
     * @param Request $request
     * @return void
     */
    public function calcAverageWpm(Request $request)
    {
        $user_id = $request->userId;
        if (isset($user_id)) {
            return History::where("user_id", $user_id)->avg("wpm");
        } else {
            return false;
        }
    }
}
