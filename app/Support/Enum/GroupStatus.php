<?php

namespace Vanguard\Support\Enum;

class GroupStatus
{
    const INACTIVE = 'Inactive';
    const ACTIVE = 'Active';

    public static function lists()
    {
        return [
            self::ACTIVE => trans('app.'.self::ACTIVE),
            self::INACTIVE => trans('app.' . self::INACTIVE)
        ];
    }
}
