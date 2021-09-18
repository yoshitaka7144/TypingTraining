<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\QuestionRequest;
use App\Question;

/**
 * 問題コントローラー
 */
class QuestionController extends Controller
{
    /**
     * 問題一覧データ取得
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        // カテゴリー名を取得したいのでcategoriesテーブルとjoin
        $questions = Question::select("questions.id as id", "categories.name as category", "text", "kana", "roman", "editor_user_id")->join("categories", "categories.id", "=", "questions.category_id")->orderBy($request->orderColumn, $request->orderType);

        // 編集可能データのみ表示にチェック有の場合、編集者のデータのみ取得
        if (isset($request->editorUserId)) {
            $questions = $questions->where("editor_user_id", $request->editorUserId);
        }

        // 検索条件がセットされている場合
        if (isset($request->searchColumn) && isset($request->searchText)) {
            $questions = $questions->where($request->searchColumn, "like", "%" . $request->searchText . "%");
        }

        $questions = $questions->paginate($request->perPage);
        return $questions;
    }

    /**
     * 問題を取得
     *
     * @param Question $question
     * @return void
     */
    public function show(Question $question)
    {
        return $question;
    }

    /**
     * 問題登録
     *
     * @param QuestionRequest $request
     * @return void
     */
    public function store(QuestionRequest $request)
    {
        $question = new Question();
        $question->category_id = $request->categoryId;
        $question->text = $request->text;
        $question->kana = $request->kana;
        $question->roman = $request->roman;
        $question->editor_user_id = $request->editorUserId;
        $question->save();

        return $question;
    }

    /**
     * 問題更新
     *
     * @param QuestionRequest $request
     * @param Question $question
     * @return void
     */
    public function update(QuestionRequest $request, Question $question)
    {
        $question->category_id = $request->categoryId;
        $question->text = $request->text;
        $question->kana = $request->kana;
        $question->roman = $request->roman;
        $question->editor_user_id = $request->editorUserId;
        $question->save();

        return $question;
    }

    /**
     * 問題削除
     *
     * @param Question $question
     * @return void
     */
    public function destroy(Question $question)
    {
        $question->delete();

        return $question;
    }

    /**
     * 指定カテゴリーの問題を取得
     *
     * @param int $categoryId
     * @return void
     */
    public function category($categoryId)
    {
        return Question::where("category_id", $categoryId)->inRandomOrder()->get();
    }
}
