<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\People;

class ContributorAgeValidateRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $person = People::find($value);
        $birthdayPerson = $person->birthday;

        if(!$person){
            $fail("Pessoa não encontrada com o ID informado.");
        }
        if ($birthdayPerson === null) {
            $fail('Data de nascimento do contribuinte não foi informada.');
            return;
        }

        $birthdayPerson = Carbon::parse($birthdayPerson); 

        //diffInYears calcula a dif entre a data_atual e a data_nasc
        $age = $birthdayPerson->diffInYears(Carbon::now()); 
 
        if ($age < 16) {
            $fail('O contribuinte deve ter no mínimo 16 anos.');
            return;
        }
    }
}
