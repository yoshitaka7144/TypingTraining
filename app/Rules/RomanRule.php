<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * タイピング文字用バリデーションルール
 */
class RomanRule implements Rule
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
        return preg_match('/^[a-z0-9\-,\.]+$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ":attribute は半角数字 or 英小文字 or 記号（-,.）で入力してください";
    }
}
