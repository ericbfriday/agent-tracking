<?php

namespace Vanguard\Http\Requests\Handler;

use Vanguard\Http\Requests\Request;
use Vanguard\Handler;

class CreateHandlerRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|unique:handlers,name',
      
        ];

        return $rules;
    }
}
