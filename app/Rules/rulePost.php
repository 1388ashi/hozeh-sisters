<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class rulePost implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $rules= [
            'title' =>'required',
            'subtitle' =>'required',
            'summary' =>'required',
            'body' =>'required',
            'image' => 'required'
        ];
    }
    public function message()
    {
        $messages = [
            'title.required' => "عنوان الزامی است",
            'subtitle.required' => "فیلد رو تیتر الزامی است",
            'summary.required' => "فیلد توضیحات کوتاه الزامی است",
            'body.required' => "فیلد توضیحات  الزامی است",
            'image.required' => "تصویر  الزامی است"
        ];
    }
}
