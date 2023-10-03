<?php

namespace Vanguard\Presenters;

use Vanguard\Support\Enum\HandlerStatus;
use Illuminate\Support\Str;
use Laracasts\Presenter\Presenter;
use Vanguard\Handler;
use Vanguard\Agent;

class HandlerPresenter extends Presenter
{
	public function name()
	{
		return sprintf("%s", $this->entity->name);
	}

	public function gsf_forum_name()
	{
		return sprintf("%s", $this->entity->gsf_forum_name);
	}

	public function skype_name()
	{
		return sprintf("%s", $this->entity->skype_name);
	}

	public function discord_name()
	{
		return sprintf("%s", $this->entity->discord_name);
	}

	public function timezone()
	{
		return sprintf("%s", $this->entity->timezone);
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
    		case HandlerStatus::ACTIVE:
    		$class = 'success';
    		break;

    		default:
    		$class = 'warning';
    	}

    	return $class;
    }


    public function countAgents($handler) {

        $agents = Agent::where('handler', $handler) 
        ->count();
       
        return $agents;

    }

}
