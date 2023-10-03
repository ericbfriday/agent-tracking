<?php

namespace Vanguard\Http\Requests\AgentNotes;

use Vanguard\Http\Requests\Request;
use Vanguard\AgentNotes;

class CreateAgentNotesRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [

         'subject' => 'required',
         'owner' => 'required',
     ];

     return $rules;
 }
}
