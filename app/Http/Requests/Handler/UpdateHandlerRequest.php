<?php

namespace Vanguard\Http\Requests\Handler;

use Illuminate\Validation\Rule;
use Vanguard\Http\Requests\Request;
use Vanguard\Support\Enum\HandlerStatus;
use Vanguard\Handler:

class UpdateHandlerRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $handler = $this->handler();

        return [
        ];
    }
}
