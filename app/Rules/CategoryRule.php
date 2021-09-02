<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Category;

class CategoryRule implements Rule
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
        $category = Category::find($value);
        return isset($category);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ":attribute が不正な値です";
    }
}
