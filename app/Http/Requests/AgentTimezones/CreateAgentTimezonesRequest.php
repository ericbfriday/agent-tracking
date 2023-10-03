<?php

namespace Vanguard\Http\Requests\AgentTimezones;

use Vanguard\Http\Requests\Request;

class CreateAgentTimezonesRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required',
            //'description' => 'required',
        ];

        return $rules;
    }
}
