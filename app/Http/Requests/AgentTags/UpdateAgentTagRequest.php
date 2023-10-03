<?php

namespace Vanguard\Http\Requests\AgentTags;

use Vanguard\Http\Requests\Request;

class UpdatePostsRequest extends Request
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
