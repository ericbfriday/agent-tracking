<?php

namespace Vanguard\Http\Requests\Posts;

use Vanguard\Http\Requests\Request;
use Vanguard\Posts;

class CreatePostsRequest extends Request
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
            'description' => 'required',
        ];

        return $rules;
    }
}
