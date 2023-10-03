<?php

namespace Vanguard\Presenters;

use Illuminate\Support\Str;
use Laracasts\Presenter\Presenter;

class AgentNotesPresenter extends Presenter
{
	public function agent()
	{
		return sprintf("%s", $this->entity->agent);
	}

	public function handler()
	{
		return sprintf("%s", $this->entity->handler);
	}

	public function owner()
	{
		return sprintf("%s", $this->entity->owner);
	}

	public function subject()
	{
		return sprintf("%s", $this->entity->subject);
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

}
