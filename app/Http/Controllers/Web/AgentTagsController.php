<?php

namespace Vanguard\Http\Controllers\Web;

use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Requests\AgentTags\CreateAgentTagsRequest;
use Vanguard\Http\Requests\AgentTags\UpdateDetailsRequest;
use Vanguard\Repositories\AgentTags\AgentTagsRepository;
use Vanguard\AgentTags;
use Vanguard\Agent;
use Vanguard\Handler;
use Auth;
use Illuminate\Support\Facades\Input;
use Vanguard\AgentHasTag;

use \DiscordWebhooks\Client;
use \DiscordWebhooks\Embed;

class AgentTagsController extends Controller
{
    /**
     * @var AgentTagsRepository
     */
    private $tags;

    /**
     * AgentTagsController constructor.
     * @param AgentTagsRepository $tags
     */
    public function __construct(AgentTagsRepository $tags)
    {
        $this->middleware('auth');
        //$this->middleware('permission:posts.manage');
        $this->tags = $tags;
    }

    /**
     * Display paginated list of all tags.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        $tags = AgentTags::orderBy('name', 'ASC')->get();
        

        return view('agent_tags.list', compact('tags'));
    }


    /**
     * Displays form for creating a new tag.
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

        $is_hidden = [
            '0'       => 'No',
            '1'      => 'Yes',
        ];
    	
        return view('agent_tags.add', compact('colour_tags', 'is_hidden'));
    }


    /**
     * Stores new tags into the database.
     *
     * @param CreateAgentTagsRequest $request
     * @return mixed
     */
    public function store(CreateAgentTagsRequest $request)
    {

        $data = $request->all();

        $this->tags->create($data);

        return redirect()->route('agent_tags.list')
        ->withSuccess('Agent TagCreated');
    }

    /**
     * Displays tags page.
     *
     * @param AgentTags $tags
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
        public function view(AgentTags $tag)
        {
            $agents_have_tag = AgentHasTag::where('tag_id', $tag->id)
            ->with('agent')
            ->get();

            return view('agent_tags.view', compact('tag', 'agents_have_tag'));
        }

    /**
     * Displays edit tag form.
     *
     * @param AgentTags $tag
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(AgentTags $tag)
    {

        $edit = true;

        $colour_tags = [
            'primary'       => 'Blue',
            'info'          => 'Light Blue',
            'success'       => 'Green',
            'danger'        => 'Red',
            'warning'       => 'Yellow',
        ];

        $is_hidden = [
            '0'       => 'No',
            '1'      => 'Yes',
        ];

        return view(
            'agent_tags.edit',
            compact('edit', 'tag', 'colour_tags', 'is_hidden')
        );
    }

    /**
     * Updates tag details.
     *
     * @param AgentTags $tag
     * @param UpdateDetailsRequest $request
     * @return mixed
     */
    public function updateDetails(AgentTags $tag, UpdateDetailsRequest $request)
    {
        $data = $request->all();

        $this->tags->update($tag->id, $data);

        return redirect()->route('agent_tags.show', $tag->id)
        ->withSuccess('Agent Tag Updated');
    }

    public function delete(AgentTags $tag) 
    {
      // Check No Agent has a Tag Assigned.

      $relationships = AgentHasTag::where('tag_id', $tag->id)->delete();

      $this->tags->delete($tag->id);
      
      return redirect()->back()->withSuccess('Agent Tag Delete');

   }

   // Assigns a tag to the current agent
   public function assignTag($agent_id, $tag_id) {

    $user = Auth::user();
    $owner = $user->username;

    // Check if spy master or if agent belongs to user/handler.
    if($this->agentBelongsToMe($owner, $agent_id) || Auth::user()->hasRole('Spymaster')) {

    // Check Tag Exists
    $tag = AgentTags::where('id', $tag_id)->first();
    if (!$tag) { 
        return redirect()->back()->withErrors('Tag does not exist, stop being a fucking dick.');
    }

    // Check Agent Exists
    $agent_exists = Agent::where('id', $agent_id)->first();
    if (!$agent_exists) { 
        return redirect()->back()->withErrors('Agent does not exist, stop being a fucking dick.');
    }

    // Check Agent hasn't already had tag assigned
    $exists = AgentHasTag::where('agent_id', $agent_id)
    ->where('tag_id', $tag_id)
    ->first();

    if ($exists) {
        return redirect()->back()->withErrors('This Agent already has this tag assigned.');
    }

    // Create the Tag Relationship
    $add = new AgentHasTag;

    $add->agent_id = $agent_id;
    $add->tag_id = $tag_id;
    $add->save();

    // Should add code in here to not post a note, if tag is hidden.
    AgentsController::addContactNote($agent_id, 'Agent Tag ' . $tag->name . ' Assigned', $owner);

    $discord_webhook = env('AGENT_TAGS_DISCORD_WEBHOOK');
    if($discord_webhook) {
        $webhook = new Client($discord_webhook);
        $embed = new Embed();
        $embed->description('Agent Name :      **' . $agent_exists->name . '\'s** has had Tag (**' . $tag->name . '**) Assigned by: **' . $owner . '**');
        $webhook->username('Undercover')->message('**Black Hand Tools - New Agent Tag**')->embed($embed)->send();
    }

    return redirect()->back()->withSuccess('Agent Tag Assigned');
    } else {
        return redirect()->back()->withErrors('This agent does not belong to you.');
    }

   }

      // Delets a tag to the current agent
      public function removeTag($agent_id, $tag_id) {

        $user = Auth::user();
        $owner = $user->username;

        // Check if spy master or if agent belongs to user/handler.
        if($this->agentBelongsToMe($owner, $agent_id) || Auth::user()->hasRole('Spymaster')) {
    
        // Check Tag Exists
        $tag = AgentTags::where('id', $tag_id)->first();
        if (!$tag) { 
            return redirect()->back()->withErrors('Tag does not exist, stop being a fucking dick.');
        }
    
        // Check Agent Exists
        $agent_exists = Agent::where('id', $agent_id)->first();
        if (!$agent_exists) { 
            return redirect()->back()->withErrors('Agent does not exist, stop being a fucking dick.');
        }
    
        // Check Agent hasn't already had tag assigned
        $exists = AgentHasTag::where('agent_id', $agent_id)
        ->where('tag_id', $tag_id)
        ->first();
    
        if (!$exists) {
            return redirect()->back()->withErrors('This Agent does not have this tag assigned.');
        }
    
        // Create the Tag Relationship
        $exists->delete();
        
        // Should add code in here to not post a note, if tag is hidden.
        AgentsController::addContactNote($agent_id, 'Agent Tag ' . $tag->name . ' Removed', $owner);

        $discord_webhook = env('AGENT_TAGS_DISCORD_WEBHOOK');
        if($discord_webhook) {
            $webhook = new Client($discord_webhook);
            $embed = new Embed();
            $embed->description('Agent Name :      **' . $agent_exists->name . '\'s** has had Tag (**' . $tag->name . '**) Removed by: **' . $owner . '**');
            $webhook->username('Undercover')->message('**Black Hand Tools - Agent Tag Removed**')->embed($embed)->send();
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
