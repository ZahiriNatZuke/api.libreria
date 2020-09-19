<?php

namespace App\Rules;

use App\Models\Genero;
use Illuminate\Contracts\Validation\Rule;

class arrayGendersValid implements Rule
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
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $array = explode(',', $value);
        foreach ($array as $item) {
            $temp = Genero::query()->where('genero', trim($item))->first();
            if (!$temp) return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a array of genders.';
    }
}
