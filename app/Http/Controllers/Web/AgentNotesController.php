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
use Vanguard\Http\Requests\AgentNotes\CreateAgentNotesRequest;
use Vanguard\Http\Requests\AgentNotes\UpdateDetailsRequest;
use Vanguard\Http\Requests\AgentNotes\UpdateAgentNotesRequest;
use Vanguard\Repositories\AgentNotes\AgentNotesRepository;
use Vanguard\Repositories\Agent\AgentRepository;
use Vanguard\Repositories\Handler\HandlerRepository;
use Vanguard\Repositories\User\UserRepository;
use Vanguard\Repositories\Group\GroupRepository;
use Vanguard\Support\Enum\AgentNoteCategories;
use Vanguard\Support\Enum\AgentNotePriority;
use Vanguard\AgentNotes;
use Vanguard\Agent;
use Vanguard\Handler;
use Vanguard\User;
use Vanguard\Role;
use Vanguard\ContactNotifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use \DiscordWebhooks\Client;
use \DiscordWebhooks\Embed;

use Auth;


class AgentNotesController extends Controller
{
        /**
     * @var AgentsRepository
     */
        private $agentNotes;

    /**
     * AgentsController constructor.
     * @param AgentsRepository $agents
     */
    public function __construct(AgentNotesRepository $agentNotes)
    {
    	$this->middleware('auth');
    	$this->agentNotes = $agentNotes;
    }

    /**
     * Display paginated list of all agent notes.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(HandlerRepository $handlerRepository, AgentRepository $agentRepository)
    {
		/*
    	$agentNotes = $this->agentNotes->paginate(
    		$perPage = 20,
    		Input::get('search'),
    		Input::get('category'),
    		Input::get('priority'),
    		Input::get('agents'),
    		Input::get('handlers'),
    		Input::get('owner')

    	);
		

    	$owners = AgentNotes::groupBy('owner')
    	->get();

    	$owner = [

    		"" => "All",

    	];

    	foreach ($owners as $note_owner) {

    		$owner[$note_owner->owner] = $note_owner->owner;

    	}


    	$category =  ['' => trans('app.all')] + AgentNoteCategories::lists();
    	$priority =  ['' => trans('app.all')] + AgentNotePriority::lists();
    	$handlers =  $handlerRepository->lists();
    	$agents =  $agentRepository->lists();

    	$agents->prepend('All', '');
    	$handlers->prepend('All', '');
		*/

		$agentNotes = AgentNotes::orderBy('created_at', 'DESC')->get();

    	return view('agentnotes.list', compact('agentNotes'));
    }

    /**
     * Display paginated list of all agent notes.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function allAgentNotes($agent)
    {

    	$user = Auth::user();
    	$owner = $user->username;

    	$agent_details = Agent::where('id', $agent)
    	->first();

    	if (Auth::user()->hasRole('Spymaster')) {


    		$agentNotes = AgentNotes::where('agent', $agent_details->name) 
    		->orderBy('created_at', 'desc')
    		->paginate(20);

    		return view('agentnotes.agent-list', compact('agentNotes', 'agent_details'));


    	}

    	if($agent_details->owner == $owner) {


    		$agentNotes = AgentNotes::where('agent', $agent_details->name) 
    		->orderBy('created_at', 'desc')
    		->paginate(20);

    		return view('agentnotes.agent-list', compact('agentNotes', 'agent_details'));
    	} else {
    		return redirect()->route('agent.mine')
    		->withErrors('This agent does not belong to you.');
    	}

    }

      /**
     * Display paginated list of all agent notes.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

      public function view(AgentNotes $agentNotes)
      {

      	$user = Auth::user();
      	$owner = $user->username;

      	if (Auth::user()->hasRole('Spymaster')) {
      		return view('agentnotes.view', compact('agentNotes'));
      	}

      	if($agentNotes->owner == $owner) {
      		return view('agentnotes.view', compact('agentNotes'));
      	} else {
      		return redirect()->route('agent.mine')
      		->withErrors('This agent does not belong to you.');
      	}

      }


    /**
     * Displays form for creating a new agent note.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request, GroupRepository $groupRepository, UserRepository $userRepository, HandlerRepository $handlerRepository, AgentRepository $agentRepository, AgentNotesRepository $agentNotesRepository, AgentNotes $agentNotes, Agent $agent, $noteid)
    {

    	$edit = false;

    	$agent['id'] = $noteid;

    	$agent_information = Agent::find($noteid);

    	$groups = $groupRepository->lists();
    	$users = $userRepository->lists();
    	$handlers = $handlerRepository->lists();
    	$agents = $agentRepository->lists();
    	$category = AgentNoteCategories::lists();
    	$priority = AgentNotePriority::lists();

    	$user = Auth::user();
    	$owner = $user->username;

    	return view('agentnotes.add', compact('groups', 'users', 'handlers', 'agents', 'agent', 'agent_information', 'owner', 'category', 'priority'));
    }


    /**
     * Stores new agent into the database.
     *
     * @param CreateAgentRequest $request
     * @return mixed
     */
    public function store(CreateAgentNotesRequest $request, AgentNotes $agentNotes, Agent $agent, $noteid)
    {


    	$data = $request->all();      

    	$agentNotes = $this->agentNotes->create($data);

    	$discord_webhook = env('AGENT_NEW_CONTACT_NOTE_DISORD_WEBHOOK');

    	if($discord_webhook) {
    		$webhook = new Client($discord_webhook);
    		$embed = new Embed();
    		$embed->description('**Agent:**      ' . $agentNotes->agent . ' **Subject:** ' . $agentNotes->subject . '');
    		$webhook->username('Undercover')->message('**Black Hand Tools - New Contact Note - Priority = ' . $agentNotes->priority . '**')->embed($embed)->send(); 
    	}


    	if($agentNotes->notify_handler == "Yes") {

    		$handler = $agentNotes->handler;
    		$handlerAccount = Handler::where('name', $handler)->first();
            $to = User::where('username', $handlerAccount->owner)->first(); // Get the User Information.
            $from =  User::where('username', $agentNotes->owner)->first();
            $note_id = $agentNotes->id;

            $this->sendNotification($note_id, $to->id, $from->id);
        } 

        if($agentNotes->notify_spymaster == "Yes") {

        	$spymasterRole = Role::where('display_name', 'Spymaster')
        	->first();

        	$spymasters = User::where('role_id', $spymasterRole->id)
        	->get();

        	foreach ($spymasters as $spymaster) {

        		$to = $spymaster;
        		$from =  User::where('username', $agentNotes->owner)->first();
        		$note_id = $agentNotes->id;

        		$this->sendNotification($note_id, $to->id, $from->id);

        	}

        }

        return redirect()->route('agent.show', ['id' => $noteid])
        ->withSuccess(trans('app.agent_note_created'));

    } 

    public function sendNotification($note_id, $to, $from) {

    	$notification = new ContactNotifications;

    	$notification->note_id = $note_id;
    	$notification->to      = $to;
    	$notification->from    = $from;
    	$notification->acknowledged = false;
    	$notification->save();
    }


}
