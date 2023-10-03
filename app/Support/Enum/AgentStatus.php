<?php

namespace Vanguard\Support\Enum;

class AgentStatus
{
	const INACTIVE = 'Inactive';
	const ACTIVE = 'Active';

	public static function lists()
	{
		return [
			self::INACTIVE => trans('app.' . self::INACTIVE),
			self::ACTIVE => trans('app.'.self::ACTIVE)
		];
	}
}
