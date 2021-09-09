<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\QuestionRequest;
use App\Question;

use function PHPUnit\Framework\returnSelf;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $questions = Question::select("questions.id as id", "categories.name as category", "text", "kana", "roman", "editor_user_id")->join("categories", "categories.id", "=", "questions.category_id")->orderBy($request->orderColumn, $request->orderType);

        if (isset($request->editorUserId)) {
            $questions = $questions->where("editor_user_id", $request->editorUserId);
        }

        if (isset($request->searchColumn) && isset($request->searchText)) {
            $questions = $questions->where($request->searchColumn, "like", "%" . $request->searchText . "%");
        }

        $questions = $questions->paginate($request->perPage);
        return $questions;
    }

    public function show(Question $question)
    {
        return $question;
    }

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

    public function destroy(Question $question)
    {
        $question->delete();

        return $question;
    }

    public function category($categoryId)
    {
        return Question::where("category_id", $categoryId)->get();
    }
}
