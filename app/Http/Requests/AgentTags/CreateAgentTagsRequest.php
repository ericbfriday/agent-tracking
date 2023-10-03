<?php

namespace Vanguard\Http\Requests\AgentTags;

use Vanguard\Http\Requests\Request;

class CreateAgentTagsRequest extends Request
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
