<?php

namespace Vanguard\Http\Requests\AgentTimezones;

use Vanguard\Http\Requests\Request;

class UpdateAgentTimezonesRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $tag = $this->post();

        return [
        ];
    }
}
