<?php

namespace Vanguard\Http\Requests\AgentNotes;

use Illuminate\Validation\Rule;
use Vanguard\Http\Requests\Request;
use Vanguard\Support\Enum\AgentStatus;
use Vanguard\AgentNotes;

class UpdateAgentNotesRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $agentNotes = $this->agentNotes();

        return [

        ];
    }
}
