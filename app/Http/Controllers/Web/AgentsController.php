<?php

/*
 * Goonswarm Federation - Black Hand Tools
 *
 * Developed by scopehone <scopeh@gmail.com>
 * In conjuction with Izzy, such a hard customer! 
 *
 */

namespace Vanguard\Http\Controllers\Web;

use Vanguard\Events\Agent\UpdatedByAdmin;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Requests\Agent\CreateAgentRequest;
use Vanguard\Http\Requests\Agent\UpdateDetailsRequest;
use Vanguard\Http\Requests\Agent\UpdateLoginDetailsRequest;
use Vanguard\Repositories\Agent\AgentRepository;
use Vanguard\Repositories\Handler\HandlerRepository;
use Vanguard\Repositories\User\UserRepository;
use Vanguard\Repositories\Group\GroupRepository;
use Vanguard\Support\Enum\AgentStatus;
use Vanguard\Support\Enum\LoggerStatus;
use Vanguard\Support\Enum\TimeZones;
use Vanguard\Agent;
use Vanguard\AgentNotes;
use Vanguard\AgentTags;
use Vanguard\AgentTimezones;
use Vanguard\AgentHasTag;
use Vanguard\Group;
use Vanguard\AgentHasGroup;
use Vanguard\AgentHasTimezones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use Auth;
use Carbon\Carbon;
use Vanguard\Handler;

use \DiscordWebhooks\Client;
use \DiscordWebhooks\Embed;

class AgentsController extends Controller
{

    /**
     * @var AgentsRepository
     */
    private $agents;

    /**
     * AgentsController constructor.
     * @param AgentsRepository $agents
     */
    public function __construct(AgentRepository $agents)
    {
    	$this->middleware('auth');
    	$this->agents = $agents;
    }

    /**
     * Display paginated list of all agents.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

    	$user = Auth::user();
    	$owner = $user->username;
    	if (Auth::user()->hasRole('Spymaster')) {       

			/*
    		$agents = $this->agents->paginate(
    			$perPage = 50,
    			Input::get('search'),
    			Input::get('status')
    		);
			*/

			$agents = Agent::orderBy('name', 'ASC')->get();

    		$statuses = ['' => trans('app.all')] + AgentStatus::lists();

    		return view('agent.list', compact('agents', 'statuses'));

    	} else {
    		return redirect()->route('agent.mine')
    		->withErrors('You do not have permission to view agents that do not belong to you.');

    	}
    }


    /**
     * Exports  agents
     *
     * @param Agent $agent
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function exportAgents()
    {

    	$user = Auth::user();
    	$owner = $user->username;

    	if (Auth::user()->hasRole('Spymaster')) {

    		$agents = Agent::sortable()
    		->orderBy('name', 'ASC')
    		->get();

        // Fetch All Agent Notes
    		$filename = 'ATS_Agent_Export_' . $owner . '_' . date("Y-m-d") . '.csv';
    		$fields = array('ID', 'Name', 'Handler', 'Notes', 'Group', 'Status', 'Created', 'Updated', 'Owner', 'Logger Active', 'Logger ID', 'Jabber Name', 'Skype Name', 'Discord Name', 'Timezone', 'BH Forum Name', 'GSF Forum Name', 'Main Character Name', 'Main Character Corporation', 'Main Character Alliance', 'Relay Confirmed', 'Recieved Training Manual', 'Completed Questionaire', 'Last Contacted');
    		$export_data = $agents->toArray();

        // file creation
    		$file = fopen($filename,"w");

        // Add Headers
    		fputcsv($file, $fields);


    		foreach ($export_data as $line){
    			fputcsv($file, $line);
    		}

    		fclose($file);

        // download
    		header("Content-Description: File Transfer");
    		header("Content-Disposition: attachment; filename=".$filename);
    		header("Content-Type: application/csv; "); 

    		readfile($filename);

       // deleting file
    		unlink($filename);
    		exit();

    	} else {
    		return redirect()->back()
    		->withErrors('You do not have permission to view agents that do not belong to you.');
    	}
    }


    /**
     * Displays form for creating a new agent.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(GroupRepository $groupRepository, UserRepository $userRepository, HandlerRepository $HandlerRepository)
    {
    	$statuses = AgentStatus::lists();
    	$loggerstatus = LoggerStatus::lists();
    	$groups = $groupRepository->lists();
    	$timezones = TimeZones::lists();

    	// If Spy Master Include All Owners and Handlers

    	$user = Auth::user();
    	$owner = $user->username;

       $notes_placeholder = "
       Clone Status: Alpha/Omega<br>
       Current SP:<br>
       Active PVP: Yes/No<br>
       Any SIGs/Squads or Special Skills: N/A<br>";

       if (Auth::user()->hasRole('Spymaster')) {

    		//If Spymaster get all the shit

          $users = $userRepository->lists();
          $handlers = $HandlerRepository->lists();

      } else {

    		// If not get stuff that relates to that user.

          $users = [
           $owner => $owner    			
       ];

       $handlers = Handler::where('owner', $owner)
       ->pluck('name', 'name')
       ->all();



   }

   return view('agent.add', compact('statuses', 'groups', 'users', 'handlers', 'loggerstatus', 'timezones', 'notes_placeholder'));
}


    /**
     * Stores new agent into the database.
     *
     * @param CreateAgentRequest $request
     * @return mixed
     */
    public function store(CreateAgentRequest $request)
    {
        // When agent is created by administrator, we will set his
        // status to Active by default.
    	$data = $request->all();

    	$agent = $this->agents->create($data);

    	$discord_webhook = env('AGENT_STATUS_DISCORD_WEBHOOK');

    	if($discord_webhook) {

    		$webhook = new Client($discord_webhook);
    		$embed = new Embed();

    		$embed->description('**Agent Name :**      ' . $agent->name . ' **Handler:** ' . $agent->handler . '');

    		$webhook->username('Undercover')->message('**Black Hand Tools - New Agent Added**')->embed($embed)->send();
    	}

    	return redirect()->route('agent.show', ['id' => $agent])
    	->withSuccess('Agent Created');

    }

    /**
     * Displays agent profile page.
     *
     * @param Agent $agent
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
	public function view(Agent $agent)
	{


		$agentNotes = AgentNotes::orderBy('created_at', 'DESC')
		->where('agent', $agent->name)
		->get();

		// Agent Tags - We should split this off.
		// Check if a Spymaster, show hidden tags.
		if (Auth::user()->hasRole('Spymaster')) {

			// Show both hidden and unhidden tags. - If Spymaster
			$currentTags = AgentHasTag::where('agent_id', $agent->id)
			->whereHas('tag', function ($q) {
				$q->whereIn('is_hidden', [0,1]);
			})
			->get();

		} else {
		
			// Only show unhidden tags. - Handler
			$currentTags = AgentHasTag::where('agent_id', $agent->id)
			->whereHas('tag', function ($q) {
				$q->where('is_hidden', 0);
			})
			->get();

		}

		// Exclude any agent tags from the avaliable list, by removing those already allocated.
		$excludeTags = [];
		$excludeTags =  AgentHasTag::where('agent_id', $agent->id)
		->pluck('tag_id')
		->toArray();

		
		// Display remaining Agent tags Avaliable.
		if (Auth::user()->hasRole('Spymaster')) {
		
			// Display all tags.
			$agentTags = AgentTags::whereNotIn('id', $excludeTags)
			->orderBy('name', 'ASC')
			->get();

			} else {
			
			// Only show unhidden tags.
			$agentTags = AgentTags::whereNotIn('id', $excludeTags)
			->orderBy('name', 'ASC')
			->where('is_hidden', 0)
			->get();

		}
		// End of Tags

		// Remove Groups Already Assigned
		$excludeGroups = [];
		$excludeGroups =  AgentHasGroup::where('agent_id', $agent->id)
		->pluck('group_id')
		->toArray();

		// Avaliable Groups
		// Only show active groups tags. TODO
		$avaliableGroups = Group::whereNotIn('id', $excludeGroups)
		->orderBy('group', 'ASC')
		->where('status', 'Active')
		->pluck('group', 'id')
		->toArray();

		$agentGroups = AgentHasGroup::where('agent_id', $agent->id)
		->with('group')
		->get();

		/* Timezones */

		$avaliableTimezones = AgentHasTimezones::where('agent_id', $agent->id)
		->with('timezone')
		->get();

		// Exclude any agent tags from the avaliable list, by removing those already allocated.
		$excludeTimezones = [];
		$excludeTimezones =  AgentHasTimezones::where('agent_id', $agent->id)
		->pluck('timezone_id')
		->toArray();

		$agentTimezones = AgentTimezones::whereNotIn('id', $excludeTimezones)
		->orderBy('name', 'ASC')
		->get();

		// Fetch All Agent Notes
		$user = Auth::user();
		$owner = $user->username;

		if (Auth::user()->hasRole('Spymaster')) {
			return view('agent.view', 
			compact(
				'agent',
				'agentNotes',
				'agentTags',
				'currentTags',
				'agentGroups',
				'avaliableGroups',
				'avaliableTimezones',
				'agentTimezones'
			));
		}

		if($agent->owner == $owner) {
			return view('agent.view', 
			compact(
				'agent',
				'agentNotes',
				'agentTags',
				'currentTags',
				'agentGroups',
				'avaliableGroups',
				'avaliableTimezones',
				'agentTimezones'
			));
		} else {
			return redirect()->route('agent.mine')
			->withErrors('This agent does not belong to you.');
		}

	}




    /**
     * Displays edit agent form.
     *
     * @param Agent $agent
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Agent $agent, GroupRepository $groupRepository, UserRepository $userRepository, HandlerRepository $HandlerRepository)
    {

    	$user = Auth::user();
    	$owner = $user->username;
    	$edit = true;
    	$loggerstatus = LoggerStatus::lists();
    	$statuses = AgentStatus::lists();
    	$groups = $groupRepository->lists();
    	$timezones = TimeZones::lists();

    	if (Auth::user()->hasRole('Spymaster')) {

    		
    		$users = $userRepository->lists();
    		$handlers = $HandlerRepository->lists();
    		

    		return view(
    			'agent.edit',
    			compact('edit', 'agent', 'statuses', 'groups', 'users', 'handlers', 'loggerstatus', 'timezones')
    		);

    	}

    	if($agent->owner == $owner) {
    		$users = [
    			$owner => $owner    			
    		];

    		$handlers = Handler::where('owner', $owner)
    		->pluck('name', 'name')
    		->all();

    		return view(
    			'agent.edit',
    			compact('edit', 'agent', 'statuses', 'groups', 'users', 'handlers', 'loggerstatus', 'timezones')
    		);

    	} else {
    		
    		return redirect()->route('agent.mine')
    		->withErrors('This agent does not belong to you.');

    	}


     	// If not get stuff that relates to that user.

    	
    }





    /**
     * Updates agent details.
     *
     * @param Agent $agent
     * @param UpdateDetailsRequest $request
     * @return mixed
     */
    public function updateDetails(Agent $agent, UpdateDetailsRequest $request)
    {
    	$data = $request->all();

    	$this->agents->update($agent->id, $data);

    	event(new UpdatedByAdmin($agent));

    	return redirect()->route('agent.show', ['id' => $agent])
    	->withSuccess('Agent Updated');
    }

    /**
     * Displays my agents.
     *
     * @param Agent $agent
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function myAgents()
    {

    	$user = Auth::user();
    	$owner = $user->username;
    	$agents = Agent::sortable()
    	->where('owner', $owner)
    	->orderBy('name', 'ASC')
    	->get();

    	// Fetch All Agent Notes

    	$agentNotes = AgentNotes::orderBy('created_at', 'DESC')
    	->limit('10')
    	->get();

    	return view('agent.list', compact('agents', 'agentNotes'));
    }

    /**
     * Displays my agents.
     *
     * @param Agent $agent
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function myActiveAgents()
    {

        // Check if User/Hander Owns the Agent or is a Spymaster

    	$user = Auth::user();
    	$owner = $user->username;

    	$agents = Agent::where('owner', $owner)
    	->where('status', 'Active')
    	->orderBy('name', 'ASC')
    	->get();



    	return view('agent.list', compact('agents'));
    }

    /**
     * Displays my agents.
     *
     * @param Agent $agent
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function myInactiveAgents()
    {

    	$user = Auth::user();
    	$owner = $user->username;
    	$agents = Agent::where('owner', $owner)
    	->where('status', 'Inactive')
    	->orderBy('name', 'ASC')
    	->get();

    	return view('agent.list', compact('agents'));
    }

    /**
     * Displays my agents.
     *
     * @param Agent $agent
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function toggleRelayStatus($id)
    {

    	$user = Auth::user();
    	$owner = $user->username;

    	$agent = Agent::where('id', $id)
    	->first();

    	if (Auth::user()->hasRole('Spymaster')) {

    		if($agent->logger_active === "Active") { 

    			$agent->logger_active = "Inactive";
    			$agent->save();

    		// Post to Discord

    			$discord_webhook = env('AGENT_RELAY_CONFIRMED_DISCORD_WEBHOOK');

    			if($discord_webhook) {

    				$webhook = new Client($discord_webhook);
    				$embed = new Embed();
    				$embed->description('Agent Name :      **' . $agent->name . '\'s** relay status has been marked inactive by: **' . $owner . '**');
    				$webhook->username('Undercover')->message('**Black Hand Tools - Agent Relay Status**')->embed($embed)->send();

    			}

    		// Push Contact Note

    			$this->addContactNote($id, 'Agent Relay Status Inactive', $owner);

    			return redirect()->back()
    			->withSuccess('Relay marked as deactivated for ' . $agent->name);


    		}

    		$agent->logger_active = "Active";
    		$agent->save();

    		$discord_webhook = env('AGENT_RELAY_CONFIRMED_DISCORD_WEBHOOK');

    		if($discord_webhook) {
    			$webhook = new Client($discord_webhook);
    			$embed = new Embed();
    			$embed->description('Agent Name :      **' . $agent->name . '\'s** relay status has been marked active by: **' . $owner . '**');
    			$webhook->username('Undercover')->message('**Black Hand Tools - Agent Relay Status**')->embed($embed)->send();

    		}

    	// Push Contact Note

    		$this->addContactNote($id, 'Agent Relay Status Active', $owner);

    		return redirect()->back()
    		->withSuccess('Relay marked as active for ' . $agent->name);

    	}
    	if($this->agentBelongsToMe($owner, $id)) {

    		if($agent->logger_active === "Active") { 

    			$agent->logger_active = "Inactive";
    			$agent->save();

    		// Post to Discord

    			$discord_webhook = env('AGENT_RELAY_CONFIRMED_DISCORD_WEBHOOK');

    			if($discord_webhook) {

    				$webhook = new Client($discord_webhook);
    				$embed = new Embed();
    				$embed->description('Agent Name :      **' . $agent->name . '\'s** relay status has been marked inactive by: **' . $owner . '**');
    				$webhook->username('Undercover')->message('**Black Hand Tools - Agent Relay Status**')->embed($embed)->send();
    			}
    		// Push Contact Note

    			$this->addContactNote($id, 'Agent Relay Status Inactive', $owner);

    			return redirect()->back()
    			->withSuccess('Relay marked as deactivated for ' . $agent->name);


    		}

    		$agent->logger_active = "Active";
    		$agent->save();

    		$discord_webhook = env('AGENT_RELAY_CONFIRMED_DISCORD_WEBHOOK');

    		if($discord_webhook) {
    			
    			$webhook = new Client($discord_webhook);
    			$embed = new Embed();
    			$embed->description('Agent Name :      **' . $agent->name . '\'s** relay status has been marked active by: **' . $owner . '**');
    			$webhook->username('Undercover')->message('**Black Hand Tools - Agent Relay Status**')->embed($embed)->send();
    		}

    	// Push Contact Note

    		$this->addContactNote($id, 'Agent Relay Status Active', $owner);

    		return redirect()->back()
    		->withSuccess('Relay marked as active for ' . $agent->name);
    	} else {

    		return redirect()->back()
    		->withErrors('This agent does not belong to you.');

    	}

    }


    public function toggleAgentStatus($id)
    {

    	$user = Auth::user();
    	$owner = $user->username;

    	$agent = Agent::where('id', $id)
    	->first();

    	if (Auth::user()->hasRole('Spymaster')) {

    		if($agent->status === "Active") { 

    			$agent->status = "Inactive";
    			$agent->save();

    			$discord_webhook = env('AGENT_STATUS_DISCORD_WEBHOOK');
    			if($discord_webhook) {
    				$webhook = new Client($discord_webhook);
    				$embed = new Embed();
    				$embed->description('Agent Name :      **' . $agent->name . '\'s** has been marked inactive by: **' . $owner . '**');
    				$webhook->username('Undercover')->message('**Black Hand Tools - Agent Reporting Status**')->embed($embed)->send();
    			}

    		// Push Contact Note

    			$this->addContactNote($id, 'Agent Marked As Inactive', $owner);

    			return redirect()->back()
    			->withSuccess($agent->name . ' has been marked as inactive');


    		}

    		$agent->status = "Active";
    		$agent->save();

    		$discord_webhook = env('AGENT_STATUS_DISCORD_WEBHOOK');
    		if($discord_webhook) {
    			$webhook = new Client($discord_webhook);
    			$embed = new Embed();
    			$embed->description('Agent Name :      **' . $agent->name . '\'s** has been marked active by: **' . $owner . '**');
    			$webhook->username('Undercover')->message('**Black Hand Tools - Agent Reporting Status**')->embed($embed)->send();
    		}

    	// Push Contact Note

    		$this->addContactNote($id, 'Agent Marked As Active', $owner);

    		return redirect()->back()
    		->withSuccess($agent->name . ' has been marked as active');

    	}

    	if($this->agentBelongsToMe($owner, $id)) {

    		if($agent->status === "Active") { 

    			$agent->status = "Inactive";
    			$agent->save();

    			$discord_webhook = env('AGENT_STATUS_DISCORD_WEBHOOK');
    			if($discord_webhook) {
    				$webhook = new Client($discord_webhook);
    				$embed = new Embed();
    				$embed->description('Agent Name :      **' . $agent->name . '\'s** has been marked inactive by: **' . $owner . '**');
    				$webhook->username('Undercover')->message('**Black Hand Tools - Agent Reporting Status**')->embed($embed)->send();
    			}

    		// Push Contact Note

    			$this->addContactNote($id, 'Agent Marked As Inactive', $owner);

    			return redirect()->back()
    			->withSuccess($agent->name . ' has been marked as inactive');


    		}

    		$agent->status = "Active";
    		$agent->save();

    		$discord_webhook = env('AGENT_STATUS_DISCORD_WEBHOOK');
    		if($discord_webhook) {
    			$webhook = new Client($discord_webhook);
    			$embed = new Embed();
    			$embed->description('Agent Name :      **' . $agent->name . '\'s** has been marked active by: **' . $owner . '**');
    			$webhook->username('Undercover')->message('**Black Hand Tools - Agent Reporting Status**')->embed($embed)->send();
    		}

    	// Push Contact Note

    		$this->addContactNote($id, 'Agent Marked As Active', $owner);

    		return redirect()->back()
    		->withSuccess($agent->name . ' has been marked as active');

    	} else {

    		return redirect()->back()
    		->withErrors('This agent does not belong to you.');

    	}
    }

    public function confirmAgentRelayRunning($id)
    {

    	$user = Auth::user();
    	$owner = $user->username;

    	$agent = Agent::where('id', $id)
    	->first();

    	if (Auth::user()->hasRole('Spymaster')) {

    		$agent->confirm_relay = Carbon::now();
    		$agent->save();

    		$discord_webhook = env('AGENT_RELAY_CONFIRMED_DISCORD_WEBHOOK');

    		if($discord_webhook) {
    			$webhook = new Client($discord_webhook);
    			$embed = new Embed();
    			$embed->description('Agent Name :      **' . $agent->name . '\'s** relay has been confirmed by: **' . $owner . '**');
    			$webhook->username('Undercover')->message('**Black Hand Tools - Agent Relay Status**')->embed($embed)->send();
    		}

        // Push Contact Note

    		$this->addContactNote($id, 'Relay Confirmed Running', $owner);

    		return redirect()->back()
    		->withSuccess($agent->name . '\'s relay has been confirmed');
    	}

    	if($this->agentBelongsToMe($owner, $id)) {
    		$agent->confirm_relay = Carbon::now();
    		$agent->save();

    		$discord_webhook = env('AGENT_RELAY_CONFIRMED_DISCORD_WEBHOOK');
    		if($discord_webhook) {
    			$webhook = new Client($discord_webhook);
    			$embed = new Embed();
    			$embed->description('Agent Name :      **' . $agent->name . '\'s** relay has been confirmed by: **' . $owner . '**');
    			$webhook->username('Undercover')->message('**Black Hand Tools - Agent Relay Status**')->embed($embed)->send();
    		}

        // Push Contact Note

    		$this->addContactNote($id, 'Relay Confirmed Running', $owner);

    		return redirect()->back()
    		->withSuccess($agent->name . '\'s relay has been confirmed');

    	} else {

    		return redirect()->back()
    		->withErrors('This agent does not belong to you.');

    	}
    }

    public function confirmAgentHasRecievedManual($id)
    {

    	$user = Auth::user();
    	$owner = $user->username;

    	$agent = Agent::where('id', $id)
    	->first();

    	if (Auth::user()->hasRole('Spymaster')) {

    		$agent->recieved_training_manual = Carbon::now();
    		$agent->save();

    		$discord_webhook = env('AGENT_TRAINING_MANUAL_DISCORD_WEBHOOK');
    		if($discord_webhook) {
    			$webhook = new Client($discord_webhook);
    			$embed = new Embed();
    			$embed->description('Agent Name :      **' . $agent->name . '\'s** has recieved the training manual: Updated By: **' . $owner . '**');
    			$webhook->username('Undercover')->message('**Black Hand Tools - Agent Status Update**')->embed($embed)->send();
    		}

        // Push Contact Note

    		$this->addContactNote($id, 'Training Manual Recieved', $owner);

    		return redirect()->back()
    		->withSuccess($agent->name . '\'s has been marked as training manual recieved.');
    	}

    	if($this->agentBelongsToMe($owner, $id)) {
    		$agent->recieved_training_manual = Carbon::now();
    		$agent->save();

    		$discord_webhook = env('AGENT_TRAINING_MANUAL_DISCORD_WEBHOOK');
    		if($discord_webhook) {
    			$webhook = new Client($discord_webhook);
    			$embed = new Embed();
    			$embed->description('Agent Name :      **' . $agent->name . '\'s** has recieved the training manual: Updated By: **' . $owner . '**');
    			$webhook->username('Undercover')->message('**Black Hand Tools - Agent Status Update**')->embed($embed)->send();
    		}

        // Push Contact Note

    		$this->addContactNote($id, 'Training Manual Recieved', $owner);

    		return redirect()->back()
    		->withSuccess($agent->name . '\'s has been marked as training manual recieved.');
    	}
    	else {

    		return redirect()->back()
    		->withErrors('This agent does not belong to you.');

    	}
    }

    public function confirmAgenthasCompletedQuestionaire($id)
    {

    	$user = Auth::user();
    	$owner = $user->username;


    	$agent = Agent::where('id', $id)
    	->first();

    	if (Auth::user()->hasRole('Spymaster')) {

    		$agent->completed_questionaire = Carbon::now();
    		$agent->save();

    		$discord_webhook = env('AGENT_QUESTIONAIRE_DISCORD_WEBHOOK');
    		if($discord_webhook) {
    			$webhook = new Client($discord_webhook);
    			$embed = new Embed();
    			$embed->description('Agent Name :      **' . $agent->name . '\'s** has completed their questionaire. Updated by: **' . $owner . '**');
    			$webhook->username('Undercover')->message('**Black Hand Tools - Agent Status Update**')->embed($embed)->send();
    		}
        // Push Contact Note

    		$this->addContactNote($id, 'Questionaire Completed', $owner);

    		return redirect()->back()
    		->withSuccess($agent->name . '\'s has been marked as questionaire completed.');
    	}

    	if($this->agentBelongsToMe($owner, $id)) {

    		$agent->completed_questionaire = Carbon::now();
    		$agent->save();

    		$discord_webhook = env('AGENT_QUESTIONAIRE_DISCORD_WEBHOOK');
    		if($discord_webhook) {
    			$webhook = new Client($discord_webhook);
    			$embed = new Embed();
    			$embed->description('Agent Name :      **' . $agent->name . '\'s** has completed their questionaire. Updated by: **' . $owner . '**');
    			$webhook->username('Undercover')->message('**Black Hand Tools - Agent Status Update**')->embed($embed)->send();
    		}

        // Push Contact Note

    		$this->addContactNote($id, 'Questionaire Completed', $owner);

    		return redirect()->back()
    		->withSuccess($agent->name . '\'s has been marked as questionaire completed.');

    	} else {

    		return redirect()->back()
    		->withErrors('This agent does not belong to you.');

    	}
    }

    public function agentContacted($id)
    {

    	$user = Auth::user();
    	$owner = $user->username;

    	$agent = Agent::where('id', $id)
    	->first();

    	if (Auth::user()->hasRole('Spymaster')) {


    		$agent->last_contacted = Carbon::now();
    		$agent->save();

    		$discord_webhook = env('AGENT_LAST_CONTACTED_DISCORD_WEBHOOK');
    		if($discord_webhook) {
    			$webhook = new Client($discord_webhook);
    			$embed = new Embed();
    			$embed->description('Agent Name :      **' . $agent->name . '** was marked as contacted by: **' . $owner . '**');
    			$webhook->username('Undercover')->message('**Black Hand Tools - Agent Status Update**')->embed($embed)->send();
    		}

        // Push Contact Note

    		$this->addContactNote($id, 'Agent Contacted', $owner);

    		return redirect()->back()
    		->withSuccess($agent->name . '\'s was marked as being contacted.');
    	} 

    	if($this->agentBelongsToMe($owner, $id)) {


    		$agent->last_contacted = Carbon::now();
    		$agent->save();

    		$discord_webhook = env('AGENT_LAST_CONTACTED_DISCORD_WEBHOOK');
    		if($discord_webhook) {
    			$webhook = new Client($discord_webhook);
    			$embed = new Embed();
    			$embed->description('Agent Name :      **' . $agent->name . '** was marked as contacted by: **' . $owner . '**');
    			$webhook->username('Undercover')->message('**Black Hand Tools - Agent Status Update**')->embed($embed)->send();
    		}

       			// Push Contact Note

    		$this->addContactNote($id, 'Agent Contacted', $owner);

    		return redirect()->back()
    		->withSuccess($agent->name . '\'s was marked as being contacted.');
    		

    	} else {

    		return redirect()->back()
    		->withErrors('This agent does not belong to you.');

    	}

    }


    public static function addContactNote($id, $message, $owner) {

    	// Get the Agent 
    	$agent = Agent::where('id', $id)
    	->first();

    	$contactNote = new AgentNotes;

    	$contactNote->agent = $agent->name;
    	$contactNote->handler = $agent->handler;
    	$contactNote->owner = 'Black Hand System';
    	$contactNote->subject = $message;
    	$contactNote->notify_handler = 'No';
    	$contactNote->notify_spymaster = 'No';
    	$contactNote->category = 'System';
    	$contactNote->priority = 'None';
    	$contactNote->notes = 'Automatic System Contact Note. Action carried out by ' . $owner;
    	$contactNote->save();

    }

    public function agentBelongsToMe($owner, $agent_id) {

    	$handlers = Handler::where('owner', $owner)
    	->get();

    	$agent = Agent::where('id', $agent_id)
    	->first();

    	foreach($handlers as $handler) {

    		if($agent->handler == $handler->name) {
    			return true;
    		}

    		return false;
    	}

    }


}

