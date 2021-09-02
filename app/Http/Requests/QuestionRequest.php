<?php

namespace App\Http\Requests;

use App\Rules\CategoryRule;
use App\Rules\QuestionTextRule;
use App\Rules\RomanRule;
use App\Rules\KanaRule;

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
            "categoryId" => ["required", new CategoryRule],
            "text" => ["required", new QuestionTextRule, "max:100"],
            "kana" => ["required", new KanaRule, "max:100"],
            "roman" => ["required", new RomanRule, "max:100"],
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
