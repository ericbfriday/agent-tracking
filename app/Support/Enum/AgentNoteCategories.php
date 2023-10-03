<?php

namespace Vanguard\Support\Enum;

class AgentNoteCategories
{
	const ROUTINE = 'Routine';
	const TIME_SENSITIVE = 'Time Sensitive';
	const OTHER = 'Other';
	const SYSTEM = 'System';

	public static function lists()
	{
		return [
			self::ROUTINE => self::ROUTINE,
			self::TIME_SENSITIVE => self::TIME_SENSITIVE,
			self::OTHER => self::OTHER,
			self::SYSTEM => self::SYSTEM,
		];
	}
}
