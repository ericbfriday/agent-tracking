<?php

namespace Vanguard\Presenters;

use Illuminate\Support\Str;
use Laracasts\Presenter\Presenter;
use Vanguard\Handler;
use Vanguard\Agent;
use Vanguard\ContactNotifications;
use Vanguard\AgentNotes;
use Vanguard\User;

class NotificationsPresenter extends Presenter
{
	public function agentNote($id) {

		$agentNote = AgentNotes::where('id', $id) 
		->first();

		return $agentNote;

	}

		public function getUser($id) {

		$agentNote = User::where('id', $id) 
		->first();
		
		return $agentNote;

	}

}
