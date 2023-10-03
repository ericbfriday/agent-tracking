<?php

namespace Vanguard\Http\Requests\Posts;

use Illuminate\Validation\Rule;
use Vanguard\Http\Requests\Request;
use Vanguard\Posts;

class UpdatePostsRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $post = $this->post();

        return [
        ];
    }
}
