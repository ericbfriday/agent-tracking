<?php

namespace Vanguard\Support\Enum;

class Timezones
{
    const GMT = 'GMT - London';
    const PST = 'PST - Los Angeles';
    const EST = 'EST - New York';
    const CET = 'CET - Copenhagen';
    const CST = 'CST - Central';
    const MSK = 'MSK - Moscow';
    const MST = 'MST - Mountain';
    const AEST = 'AEST - Sydney';


    public static function lists()
    {
        return [
            self::GMT => trans(self::GMT),
            self::PST => trans(self::PST),
            self::EST => trans(self::EST),
            self::CET => trans(self::CET),
            self::CST => trans(self::CST),    
            self::MSK => trans(self::MSK),
            self::MST => trans(self::MST),    
            self::AEST => trans(self::AEST),           
        ];
    }
}
