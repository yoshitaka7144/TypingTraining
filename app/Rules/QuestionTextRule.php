<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class QuestionTextRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //
        return preg_match("/^[0-9ぁ-んァ-ヶ一-龠々ー、。,\.]+$/u", $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ":attribute は漢字 or カタカナ or ひらがな or 記号（,.、。）で入力してください";
    }
}
