<?php

namespace App\Http\Controllers;

use App\Category;

/**
 * カテゴリーコントローラー
 */
class CategoryController extends Controller
{
    /**
     * カテゴリー全データ取得
     *
     * @return void
     */
    public function index()
    {
        return Category::all();
    }
}
