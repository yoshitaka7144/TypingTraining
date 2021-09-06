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
            return History::where("user_id", $user_id)->where("category_id", $category_id)->orderBy("created_at","desc")->paginate($request->perPage);
        } else if (isset($user_id) && !isset($category_id)) {
            return History::where("user_id", $user_id)->orderBy("created_at","desc")->get();
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
}
