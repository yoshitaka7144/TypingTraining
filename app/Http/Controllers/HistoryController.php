<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\History;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $user_id = $request->userId;
        $category_id = $request->categoryId;
        if (isset($user_id) && isset($category_id)) {
            return History::where("user_id", $user_id)->where("category_id", $category_id)->orderBy("created_at", "desc")->paginate($request->perPage);
        } else if (isset($user_id) && !isset($category_id)) {
            return History::select("categories.name as category", "wpm", "correct_percentage", "miss_key", "histories.created_at as created_at")->join("categories", "categories.id", "=", "histories.category_id")->where("user_id", $user_id)->orderBy("created_at", "desc")->paginate($request->perPage);
        } else {
            return false;
        }
    }

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
