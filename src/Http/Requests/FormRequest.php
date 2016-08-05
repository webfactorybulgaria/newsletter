<?php

namespace TypiCMS\Modules\Newsletter\Http\Requests;

use TypiCMS\Modules\Core\Custom\Http\Requests\AbstractFormRequest;

class FormRequest extends AbstractFormRequest
{
    public function rules()
    {
        $rules = [
            'email'      => 'required|email|max:255',
        ];

        return $rules;
    }
}
