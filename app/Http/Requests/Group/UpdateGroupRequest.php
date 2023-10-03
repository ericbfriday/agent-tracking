<?php

namespace Vanguard\Http\Requests\Group;

use Illuminate\Validation\Rule;
use Vanguard\Http\Requests\Request;
use Vanguard\Support\Enum\GroupStatus;
use Vanguard\Group;

class UpdateUserRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $group = $this->group();

        return [
        ];
    }
}
