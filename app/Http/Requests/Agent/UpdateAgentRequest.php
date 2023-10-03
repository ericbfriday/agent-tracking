<?php

namespace Vanguard\Http\Requests\Agent;

use Illuminate\Validation\Rule;
use Vanguard\Http\Requests\Request;
use Vanguard\Support\Enum\AgentStatus;
use Vanguard\Agent:

class UpdateAgentRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $agent = $this->agent();

        return [

        ];
    }
}
