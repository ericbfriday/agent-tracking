<?php

namespace Vanguard\Http\Controllers\Web;

use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Requests\AgentTimezones\CreateAgentTimezonesRequest;
use Vanguard\Http\Requests\AgentTimezones\UpdateDetailsRequest;
use Vanguard\Repositories\AgentTimezones\AgentTimezonesRepository;
use Vanguard\AgentTimezones;
use Vanguard\Agent;
use Vanguard\Handler;
use Auth;
use Illuminate\Support\Facades\Input;
use Vanguard\AgentHasTimezones;

use \DiscordWebhooks\Client;
use \DiscordWebhooks\Embed;

class AgentTimezonesController extends Controller
{
   /**
     * @var AgentTimezonesRepository
     */
    private $timezones;

    /**
     * AgentTimezonesController constructor.
     * @param AgentTimezonesRepository $timezones
     */
    public function __construct(AgentTimezonesRepository $timezones)
    {
        $this->middleware('auth');
        //$this->middleware('permission:posts.manage');
        $this->timezones = $timezones;
    }

    /**
     * Display paginated list of all timezones.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        $timezones = AgentTimezones::orderBy('name', 'ASC')->get();
        

        return view('agent_timezones.list', compact('timezones'));
    }


    /**
     * Displays form for creating a new timezone.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {

        $colour_tags = [
            'primary'       => 'Blue',
            'info'          => 'Light Blue',
            'success'       => 'Green',
            'danger'        => 'Red',
            'warning'       => 'Yellow',
        ];

    	
        return view('agent_timezones.add', compact('colour_tags'));
    }


    /**
     * Stores new timezone into the database.
     *
     * @param CreateAgentTimezonesRequest $request
     * @return mixed
     */
    public function store(CreateAgentTimezonesRequest $request)
    {

        $data = $request->all();

        $this->timezones->create($data);

        return redirect()->route('agent_timezones.list')
        ->withSuccess('Agent Timezone Created');
    }

    /**
     * Displays timezones page.
     *
     * @param AgentTimezones $timezones
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
        public function view(AgentTimezones $timezone)
        {
            $agents_have_timezone = AgentHasTimezones::where('timezone_id', $timezone->id)
            ->with('agent')
            ->get();

            return view('agent_timezones.view', compact('timezone', 'agents_have_timezone'));
        }

    /**
     * Displays edit tag form.
     *
     * @param AgentTimezones $timezones
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(AgentTimezones $timezone)
    {

        $edit = true;

        $colour_tags = [
            'primary'       => 'Blue',
            'info'          => 'Light Blue',
            'success'       => 'Green',
            'danger'        => 'Red',
            'warning'       => 'Yellow',
        ];

        return view(
            'agent_timezones.edit',
            compact('edit', 'timezone', 'colour_tags')
        );
    }

    /**
     * Updates tag details.
     *
     * @param AgentTimezones $tag
     * @param UpdateDetailsRequest $request
     * @return mixed
     */
    public function updateDetails(AgentTimezones $timezone, UpdateDetailsRequest $request)
    {
        $data = $request->all();

        $this->timezones->update($timezone->id, $data);

        return redirect()->route('agent_timezones.show', $timezone->id)
        ->withSuccess('Agent Timezone Updated');
    }

    public function delete(AgentTimezones $timezone) 
    {
      // Check No Agent has a Tag Assigned.

      $relationships = AgentHasTimezones::where('timezone_id', $timezone->id)->get();

      $this->timezones->delete($timezone->id);
      
      return redirect()->back()->withSuccess('Agent Timezone Deleted');

   }

   // Assigns a tag to the current agent
   public function assignTimezone($agent_id, $timezone_id) {

    $user = Auth::user();
    $owner = $user->username;

    // Check if spy master or if agent belongs to user/handler.
    if($this->agentBelongsToMe($owner, $agent_id) || Auth::user()->hasRole('Spymaster')) {

    // Check Tag Exists
    $timezone = AgentTimezones::where('id', $timezone_id)->first();
    if (!$timezone) { 
        return redirect()->back()->withErrors('Timezone does not exist, stop being a fucking dick.');
    }

    // Check Agent Exists
    $agent_exists = Agent::where('id', $agent_id)->first();
    if (!$agent_exists) { 
        return redirect()->back()->withErrors('Agent does not exist, stop being a fucking dick.');
    }

    // Check Agent hasn't already had timezone assigned
    $exists = AgentHasTimezones::where('agent_id', $agent_id)
    ->where('timezone_id', $timezone_id)
    ->first();

    if ($exists) {
        return redirect()->back()->withErrors('This Agent already has this timezone assigned.');
    }

    // Create the Timezone Relationship
    $add = new AgentHasTimezones;

    $add->agent_id = $agent_id;
    $add->timezone_id = $timezone_id;
    $add->save();

    // Should add code in here to not post a note, if timezone is hidden.
    AgentsController::addContactNote($agent_id, 'Agent Timezone ' . $timezone->name . ' Assigned', $owner);

    $discord_webhook = env('AGENT_TAGS_DISCORD_WEBHOOK');
    if($discord_webhook) {
        $webhook = new Client($discord_webhook);
        $embed = new Embed();
        $embed->description('Agent Name :      **' . $agent_exists->name . '\'s** has had Timezone (**' . $timezone->name . '**) Assigned by: **' . $owner . '**');
        $webhook->username('Undercover')->message('**Black Hand Tools - New Agent Timezone**')->embed($embed)->send();
    }

    return redirect()->back()->withSuccess('Agent Timezone Assigned');
    } else {
        return redirect()->back()->withErrors('This agent does not belong to you.');
    }

   }

      // Deletes a tag to the current agent
      public function removeTimezone($agent_id, $timezone_id) {

        $user = Auth::user();
        $owner = $user->username;

        // Check if spy master or if agent belongs to user/handler.
        if($this->agentBelongsToMe($owner, $agent_id) || Auth::user()->hasRole('Spymaster')) {
    
        // Check Tag Exists
        $timezone = AgentTimezones::where('id', $timezone_id)->first();
        if (!$timezone) { 
            return redirect()->back()->withErrors('Timezone does not exist, stop being a fucking dick.');
        }
    
        // Check Agent Exists
        $agent_exists = Agent::where('id', $agent_id)->first();
        if (!$agent_exists) { 
            return redirect()->back()->withErrors('Agent does not exist, stop being a fucking dick.');
        }
    
        // Check Agent hasn't already had tag assigned
        $exists = AgentHasTimezones::where('agent_id', $agent_id)
        ->where('timezone_id', $timezone_id)
        ->first();
    
        if (!$exists) {
            return redirect()->back()->withErrors('This Agent does not have this timezone assigned.');
        }
    
        // Create the Tag Relationship
        $exists->delete();
        
        // Should add code in here to not post a note, if tag is hidden.
        AgentsController::addContactNote($agent_id, 'Agent Timezone ' . $timezone->name . ' Removed', $owner);

        $discord_webhook = env('AGENT_TAGS_DISCORD_WEBHOOK');
        if($discord_webhook) {
            $webhook = new Client($discord_webhook);
            $embed = new Embed();
            $embed->description('Agent Name :      **' . $agent_exists->name . '\'s** has had Timezone (**' . $timezone->name . '**) Removed by: **' . $owner . '**');
            $webhook->username('Undercover')->message('**Black Hand Tools - Agent Timezone Removed**')->embed($embed)->send();
        }
    
        return redirect()->back()->withSuccess('Agent Tag Removed');
        } else {
            return redirect()->back()->withErrors('This agent does not belong to you.');
        }
    
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
