<?php

/*
 * Goonswarm Federation - Black Hand Tools
 *
 * Developed by scopehone <scopeh@gmail.com>
 * In conjuction with Izzy, such a hard customer! 
 *
 */

namespace Vanguard\Http\Controllers\Web;

use Vanguard\Events\Group\UpdatedByAdmin;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Requests\Group\CreateGroupRequest;
use Vanguard\Http\Requests\Group\UpdateDetailsRequest;
use Vanguard\Http\Requests\Group\UpdateLoginDetailsRequest;
use Vanguard\Repositories\Group\GroupRepository;
use Vanguard\Support\Enum\GroupStatus;
use Vanguard\Support\Enum\TopSecretStatus;
use Vanguard\Group;
use Vanguard\Agent;
use Vanguard\Handler;
use Vanguard\AgentHasGroup;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use Seat\Eseye\Cache\NullCache;
use Seat\Eseye\Configuration;
use Seat\Eseye\Containers\EsiAuthentication;
use Seat\Eseye\Eseye;

use Seat\Eseye\Exceptions\EsiScopeAccessDeniedException;
use Seat\Eseye\Exceptions\InvalidContainerDataException;
use Seat\Eseye\Exceptions\RequestFailedException;

class GroupsController extends Controller
{
    /**
     * @var GroupRepository
     */
    private $groups;

    /**
     * GroupsController constructor.
     * @param GroupsRepository $groups
     */
    public function __construct(GroupRepository $groups)
    {
        $this->middleware('auth');
        //$this->middleware('session.database', ['only' => ['sessions', 'invalidateSession']]);
        //$this->middleware('permission:groups.manage');
        $this->groups = $groups;
    }

    /**
     * Display paginated list of all groups.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        $groups = Group::orderBy('group', 'ASC')->get();

        $agents = Agent::all();
        $handlers = Handler::all();
        

        return view('group.list', compact('groups', 'agents', 'handlers'));
    }


    /**
     * Displays form for creating a new group.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $statuses = GroupStatus::lists();
        $topsecret = TopSecretStatus::lists();

        return view('group.add', compact('statuses', 'topsecret'));
    }


    /**
     * Stores new group into the database.
     *
     * @param CreateGroupRequest $request
     * @return mixed
     */
    public function store(CreateGroupRequest $request)
    {
        // When group is created by administrator, we will set his
        // status to Active by default.
        $data = $request->all();

        $group = $this->groups->create($data);

        return redirect()->route('group.list')
        ->withSuccess('Group Created');
    }

        /**
     * Displays groups profile page.
     *
     * @param Group $group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
        public function view(Group $group)
        {

            // Fetch users from database
            $agents = Agent::all();
            $handlers = Handler::all();

            return view('group.view', compact('group', 'agents', 'handlers'));
        }

    /**
     * Displays edit group form.
     *
     * @param Group $group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Group $group)
    {
        $edit = true;
        $statuses = GroupStatus::lists();
        $topsecret = TopSecretStatus::lists();
        
        return view(
            'group.edit',
            compact('edit', 'group', 'statuses', 'topsecret')
        );
    }


    /**
     * Updates group details.
     *
     * @param Group $group
     * @param UpdateDetailsRequest $request
     * @return mixed
     */
    public function updateDetails(Group $group, UpdateDetailsRequest $request)
    {
        $data = $request->all();

        $this->groups->update($group->id, $data);

        event(new UpdatedByAdmin($group));

        return redirect()->route('group.show', $group->id)
        ->withSuccess('Group Dated');
    }

    /**
     * Updates ESI group details.
     *
     * @param Group $group
     * @param UpdateDetailsRequest $request
     * @return mixed
     */
    public function getESIDetails($group, $name)
    {

        $client_id = env('EVEONLINE_CLIENT_ID');
        $secret_key = env('EVEONLINE_CLIENT_SECRET');

        $esi = new Eseye();

        $categories = array();
        $categories[] = 'alliance';

        try {

            $response = $esi->setQueryString([
                'categories' => 'alliance',
                'search'     => 'Hello',
                'strict'     => 'true'

            ])->invoke('get', '/search/');

            // Checks If the Alliance is Valid.

            if(isset($response->alliance)) {


                $alliance_info = $esi->invoke('get', '/alliances/{alliance_id}/', [
                    'alliance_id' => $response->alliance,
                ]);


                


            }


        } catch (EsiScopeAccessDeniedException $e) {

            return redirect()->back()
            ->withErrors('Your ESI Token has been revoked, re-add it on the SSO page.');

        } catch (RequestFailedException $e) {

            return redirect()->back()
            ->withErrors('Got an ESI error' . $e);

        } catch (Exception $e) {

            return redirect()->back()
            ->withErrors('CCPs ESI is fucked.');
        }



        return redirect()->back()
        ->withSuccess(trans('app.group_updated'));

    }


    // Assigns a tag to the current agent
   public function assignGroup(Request $request) {

    $data = $request->all();

    $group_id = $data['group_id'];
    $agent_id = $data['agent_id'];

    $user = Auth::user();
    $owner = $user->username;

    // Check if spy master or if agent belongs to user/handler.

    if($this->agentBelongsToMe($owner, $agent_id) || Auth::user()->hasRole('Spymaster')) {

    // Check Tag Exists
    $group = Group::where('id', $group_id)->first();
    if (!$group) { 
        return redirect()->back()->withErrors('Group does not exist, stop being a fucking dick.');
    }

    // Check Agent Exists
    $agent_exists = Agent::where('id', $agent_id)->first();
    if (!$agent_exists) { 
        return redirect()->back()->withErrors('Agent does not exist, stop being a fucking dick.');
    }

    // Check Agent hasn't already had tag assigned
    $exists = AgentHasGroup::where('agent_id', $agent_id)
    ->where('group_id', $group_id)
    ->first();

    if ($exists) {
        return redirect()->back()->withErrors('This Agent already has this group assigned.');
    }

    // Create the Tag Relationship
    $add = new AgentHasGroup;

    $add->agent_id = $agent_id;
    $add->group_id = $group_id;
    $add->save();

    
    // Should add code in here to not post a note, if tag is hidden.
    AgentsController::addContactNote($agent_id, 'Agent Group ' . $group->group . ' Assigned', $owner);
    /* Disabled Webook for now.
    $discord_webhook = env('AGENT_TAGS_DISCORD_WEBHOOK');
    if($discord_webhook) {
        $webhook = new Client($discord_webhook);
        $embed = new Embed();
        $embed->description('Agent Name :      **' . $agent_exists->name . '\'s** has had Tag (**' . $tag->name . '**) Assigned by: **' . $owner . '**');
        $webhook->username('Undercover')->message('**Black Hand Tools - New Agent Tag**')->embed($embed)->send();
    }
    */

    return redirect()->back()->withSuccess('Agent Group Assigned');
    } 
    else {
    return redirect()->back()->withErrors('This agent does not belong to you.');
    }

   }

      // Delets a tag to the current agent
      public function removeGroup($agent_id, $group_id) {

        $user = Auth::user();
        $owner = $user->username;

        // Check if spy master or if agent belongs to user/handler.
        if($this->agentBelongsToMe($owner, $agent_id) || Auth::user()->hasRole('Spymaster')) {
            
    
        // Check Group Exists & is Active.
        $group = Group::where('id', $group_id)->first();
        if (!$group) { 
            return redirect()->back()->withErrors('Group does not exist, stop being a fucking dick.');
        }
    
        // Check Agent Exists
        $agent_exists = Agent::where('id', $agent_id)->first();
        if (!$agent_exists) { 
            return redirect()->back()->withErrors('Agent does not exist, stop being a fucking dick.');
        }
    
        // Check Agent hasn't already had tag assigned
        $exists = AgentHasGroup::where('agent_id', $agent_id)
        ->where('group_id', $group_id)
        ->first();
    
        if (!$exists) {
            return redirect()->back()->withErrors('This Agent does not have this group assigned.');
        }
    
        // Delete the Group Relationship
        $exists->delete();
        
        // Should add code in here to not post a note, if tag is hidden.
        AgentsController::addContactNote($agent_id, 'Agent Group ' . $group->group . ' Removed', $owner);
        /* Disabled Webook for now.
        $discord_webhook = env('AGENT_TAGS_DISCORD_WEBHOOK');
        if($discord_webhook) {
            $webhook = new Client($discord_webhook);
            $embed = new Embed();
            $embed->description('Agent Name :      **' . $agent_exists->name . '\'s** has had Tag (**' . $tag->name . '**) Removed by: **' . $owner . '**');
            $webhook->username('Undercover')->message('**Black Hand Tools - Agent Tag Removed**')->embed($embed)->send();
        }
        */
    
        return redirect()->back()->withSuccess('Agent Group Removed');
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