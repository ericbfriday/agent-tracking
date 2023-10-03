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
use Vanguard\Support\Enum\GroupStatus;
use Auth;
use Vanguard\Group;
use Vanguard\Agent;
use Carbon\Carbon;

class GroupMetricsController extends Controller
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

        $this->middleware('permission:metrics.view');

    }

    /**
     * Displays dashboard based on user's role.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

    	return $this->groupMetrics();
    }

    private function groupMetrics()
    {

    	$groupsPerMonth = $this->group->countOfNewGroupsPerMonth(
    		Carbon::now()->subYear()->startOfMonth(),
    		Carbon::now()->endOfMonth()
    	);

    	$groupstats = [
    		'total' => $this->group->count(),
    		'new' => $this->group->newGroupsCount(),
    		'active' => $this->group->countByStatus(GroupStatus::ACTIVE),
    		'inactive' => $this->group->countByStatus(GroupStatus::INACTIVE)
    	];

    	$latestGroupRegistrations = $this->group->latest(7);

    	// Bleh

    	$activeGroups = Group::where('status', 'Active')
    	->orderBy('group', 'ASC')
    	->get();

    	$activeAgents = [];

    	foreach($activeGroups as $group) {

    		if($this->countActiveAgents($group->group) > 0) {

    			$key = $group->group;

    			$activeAgents[$key] = $this->countActiveAgents($group->group);
    		}

    	}

    	$activeRelayAgents = [];

    	foreach($activeGroups as $group) {

    		if($this->countActiveRelayAgents($group->group) > 0) {

    			$key = $group->group;

    			$activeRelayAgents[$key] = $this->countActiveRelayAgents($group->group);

    		}

    	}


    	return view('metrics.groups', compact('groupstats', 'latestGroupRegistrations', 'groupsPerMonth', 'activeAgents', 'activeRelayAgents'));
    }

    
    public function countActiveAgents($group) {

    	$activeAgents = Agent::where('group', $group)
    	->where('status', 'Active')
    	->count();

    	return $activeAgents;
    }

    public function countActiveRelayAgents($group) {

    	$activeAgents = Agent::where('group', $group)
    	->where('logger_active', 'Active')
    	->count();

    	return $activeAgents;
    }
}
