<?php

namespace Vanguard\Http\Requests\Group;

use Vanguard\Http\Requests\Request;
use Vanguard\Group;

class CreateGroupRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'group' => 'required',
            'type' => 'required',
        ];

        return $rules;
    }
}
