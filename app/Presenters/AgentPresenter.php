<?php

namespace Vanguard\Presenters;

use Vanguard\Support\Enum\AgentStatus;
use Illuminate\Support\Str;
use Laracasts\Presenter\Presenter;

class AgentPresenter extends Presenter
{
	public function name()
	{
		return sprintf("%s", $this->entity->name);
	}

		public function handler()
	{
		return sprintf("%s", $this->entity->handler);
	}

		public function group()
	{
		return sprintf("%s", $this->entity->group);
	}

		public function notes()
	{
		return sprintf("%s", $this->entity->notes);
	}


	public function updated_at()
	{
		return $this->entity->updated_at
		? $this->entity->updated_at->diffForHumans()
		: '-';
	}

		public function created_at()
	{
		return $this->entity->birthday
		? $this->entity->birthday->format(config('app.date_format'))
		: '-';
	}

    /**
     * Determine css class used for status labels
     * inside the users table by checking user status.
     *
     * @return string
     */
    public function labelClass()
    {
    	switch ($this->entity->status) {
    		case AgentStatus::ACTIVE:
    		$class = 'primary';
    		break;

    		default:
    		$class = 'danger';
    	}

    	return $class;
    }
}
