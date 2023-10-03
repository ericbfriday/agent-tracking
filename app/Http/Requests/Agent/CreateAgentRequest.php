<?php

namespace Vanguard\Http\Requests\Agent;

use Vanguard\Http\Requests\Request;
use Vanguard\Agent;

class CreateAgentRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|unique:agents,name',
            'handler' => 'required',
        ];

        return $rules;
    }
}
