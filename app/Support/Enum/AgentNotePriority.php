<?php

namespace Vanguard\Support\Enum;

class AgentNotePriority
{
	const NONE = 'None';
	const ROUTINE = 'Routine';
	const IMPORTANT = 'Important';
	const URGENT = 'Urgent';

	public static function lists()
	{
		return [
			self::NONE => self::NONE,
			self::ROUTINE => self::ROUTINE,
			self::IMPORTANT => self::IMPORTANT,
			self::URGENT => self::URGENT
		];
	}
}
