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

    public function store(QuestionRequest $request){
        $question = new Question();
        $question->category = $request->category;
        $question->text = $request->text;
        $question->kana = $request->kana;
        $question->save();

        return $question;
    }
}
