<?php

namespace App\Http\Requests;

use App\Rules\QuestionText;
use App\Rules\Roman;
use App\Rules\Kana;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class QuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "category" => ["required", "string", "max:10"],
            "text" => ["required", new QuestionText, "max:100"],
            "kana" => ["required", new Kana, "max:100"],
            "roman" => ["required", new Roman, "max:100"],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $res = response()->json([
            'status' => 422,
            'errors' => $validator->errors(),
        ], 422);
        throw new HttpResponseException($res);
    }
}
