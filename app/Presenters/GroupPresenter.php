<?php

namespace Vanguard\Presenters;

use Vanguard\Support\Enum\GroupStatus;
use Illuminate\Support\Str;
use Laracasts\Presenter\Presenter;

use Vanguard\Handler;
use Vanguard\Agent;
use Vanguard\Group;

class GroupPresenter extends Presenter
{
	public function name()
	{
		return sprintf("%s", $this->entity->group);
	}

	public function type()
	{
		return sprintf("%s", $this->entity->type);
	}

	public function home()
	{
		return sprintf("%s", $this->entity->home);
	}
	public function notes()
	{
		return sprintf("%s", $this->entity->group);
	}


	public function updated_at()
	{
		return $this->entity->last_login
		? $this->entity->last_login->diffForHumans()
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
    		case GroupStatus::ACTIVE:
    		$class = 'primary';
    		break;

    		default:
    		$class = 'danger';
    	}

    	return $class;
    }

    public function countActiveAgents($group) {

    	$agents = Agent::where('group', $group) 
    	->where('status', 'Active')
    	->count();

    	return $agents;

    }

       public function countActiveAgentsRelays($group) {

    	$agents = Agent::where('group', $group) 
    	->where('logger_active', 'Active')
    	->count();

    	return $agents;

    }

    

}
