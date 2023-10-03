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
use Vanguard\Support\Enum\HandlerStatus;
use Vanguard\Agent;
use Vanguard\Handler;
use Auth;
use Carbon\Carbon;

class HandlerMetricsController extends Controller
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

    	return $this->handlerMetrics();
    }

    private function handlerMetrics()
    {

    	$handlersPerMonth = $this->handler->countOfNewHandlersPerMonth(
    		Carbon::now()->subYear()->startOfMonth(),
    		Carbon::now()->endOfMonth()
    	);

    	$handlerstats = [
    		'total' => $this->handler->count(),
    		'new' => $this->handler->newHandlersCount(),
    		'active' => $this->handler->countByStatus(HandlerStatus::ACTIVE),
    		'inactive' => $this->handler->countByStatus(HandlerStatus::INACTIVE)
    	];

    	$latestHandlerRegistrations = $this->handler->latest(7);

    	$activeHandlers = Handler::where('status', 'Active')
    	->orderBy('name', 'ASC')
    	->get();

    	$activeAgents = [];

    	foreach($activeHandlers as $handler) {

    		if($this->countActiveAgents($handler->name) > 0) {

    			$key = $handler->name;

    			$activeAgents[$key] = $this->countActiveAgents($handler->name);
    		} else {

    			$key = $handler->name;
    			$activeAgents[$key] = 0;

    		}

    	}

    	$inactiveAgents = [];

    	foreach($activeHandlers as $handler) {

    		if($this->countInactiveAgents($handler->name) > 0) {

    			$key = $handler->name;

    			$inactiveAgents[$key] = $this->countInactiveAgents($handler->name);
    		} else {

    			$key = $handler->name;
    			$inactiveAgents[$key] = 0;

    		}

    	}


    	return view('metrics.handlers', compact('handlerstats', 'latestHandlerRegistrations', 'handlersPerMonth', 'activeAgents', 'inactiveAgents'));
    }

    public function countActiveAgents($handler) {

    	$activeAgent = Agent::where('handler', $handler)
    	->where('status', 'Active')
    	->count();

    	return $activeAgent;
    }

    public function countInactiveAgents($handler) {

    	$inactiveAgent = Agent::where('handler', $handler)
    	->where('status', 'Inactive')
    	->count();

    	return $inactiveAgent;
    }
}






