<?php

namespace Vanguard\Support\Enum;

class TopSecretStatus
{
    const NOTTOPSECRET = 'Not Top Secret';
    const TOPSECRET = 'Top Secret';

    public static function lists()
    {
        return [
            self::TOPSECRET => trans('app.'.self::TOPSECRET),
            self::NOTTOPSECRET => trans('app.' . self::NOTTOPSECRET)
        ];
    }
}
