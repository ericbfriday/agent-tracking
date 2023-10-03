<?php

/*
 * Goonswarm Federation - Black Hand Tools
 *
 * Developed by scopehone <scopeh@gmail.com>
 * In conjuction with Izzy, such a hard customer! 
 *
 */

namespace Vanguard\Http\Controllers\Web;

use Vanguard\Http\Controllers\Controller;
use Vanguard\Repositories\Activity\ActivityRepository;
use Vanguard\Repositories\User\UserRepository;
use Vanguard\Repositories\Agent\AgentRepository;
use Vanguard\Repositories\Handler\HandlerRepository;
use Vanguard\Repositories\Group\GroupRepository;
use Vanguard\Support\Enum\UserStatus;
use Vanguard\Support\Enum\AgentStatus;
use Auth;
use Vanguard\Agent;
use Vanguard\AgentNotes;
use Vanguard\Group;
use Carbon\Carbon;

class AgentMetricsController extends Controller
{
    /**
     * @var AgentRepository
     */
    private $agent;
        /**
     * @var HandlerRepository
     */
        private $handler;
        /**
     * @var GroupRepository
     */
        private $group;

    /**
     * DashboardController constructor.
     * @param UserRepository $users
     * @param ActivityRepository $activities
     */
    public function __construct(AgentRepository $agent, HandlerRepository $handler, GroupRepository $group)
    {
    	$this->middleware('auth');
    	
    	$this->agent = $agent;
    	$this->handler = $handler;
    	$this->group = $group;

    }

    /**
     * Displays dashboard based on user's role.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

    	return $this->agentMetrics();
    }

    private function agentMetrics()
    {

    	$agentsPerMonth = $this->agent->countOfNewAgentsPerMonth(
    		Carbon::now()->subYear()->startOfMonth(),
    		Carbon::now()->endOfMonth()
    	);

    	$agentstats = [
    		'total' => $this->agent->count(),
    		'new' => $this->agent->newAgentsCount(),
    		'active' => $this->agent->countByStatus(AgentStatus::ACTIVE),
    		'inactive' => $this->agent->countByStatus(AgentStatus::INACTIVE),
    		'logger_active' => $this->agent->countActiveRelays(),
    	];

    	$latestAgentRegistrations = $this->agent->latest(7);

    	$activeAgents = Agent::where('status', 'Active')
    	->orderBy('name', 'ASC')
    	->get();

    	$agentStats = [];

    	foreach($activeAgents as $agent) {

    		if($this->countAgentsNotes($agent->name) > 0) {

    			$key = $agent->name;

    			$agentStats[$key] = $this->countAgentsNotes($agent->name);
    		}

    	}

    	return view('metrics.agents', compact('agentstats', 'latestAgentRegistrations', 'agentsPerMonth', 'agentStats'));
    }


    public function countAgentsNotes($agent) {

    	$agentNotes = AgentNotes::where('agent', $agent)
    	->count();

    	return $agentNotes;
    }


}


