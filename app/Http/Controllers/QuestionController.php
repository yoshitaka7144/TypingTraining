<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\QuestionRequest;
use App\Question;

class QuestionController extends Controller
{
    public function index()
    {
        return Question::all();
    }

    public function show(Question $question)
    {
        return $question;
    }

    public function store(QuestionRequest $request)
    {
        $question = new Question();
        $question->category = $request->category;
        $question->text = $request->text;
        $question->kana = $request->kana;
        $question->save();

        return $question;
    }

    public function update(QuestionRequest $request, Question $question)
    {
        $question->category = $request->category;
        $question->text = $request->text;
        $question->kana = $request->kana;
        $question->save();

        return $question;
    }

    public function destroy(Question $question){
        $question->delete();

        return $question;
    }
}
