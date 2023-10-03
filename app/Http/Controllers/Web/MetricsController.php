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
use Carbon\Carbon;

class MetricsController extends Controller
{
    /**
     * @var UserRepository
     */
    private $users;
    /**
     * @var ActivityRepository
     */
    private $activities;
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
    public function __construct(UserRepository $users, ActivityRepository $activities, AgentRepository $agent, HandlerRepository $handler, GroupRepository $group)
    {
    	$this->middleware('auth');
    	$this->users = $users;
    	$this->activities = $activities;
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

    	return $this->metricsDashboard();
    }

    /**
     * Displays metrics dashboard for users.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function metricsDashboard()
    {
    	$usersPerMonth = $this->users->countOfNewUsersPerMonth(
    		Carbon::now()->subYear()->startOfMonth(),
    		Carbon::now()->endOfMonth()
    	);

    	$stats = [
    		'total' => $this->users->count(),
    		'new' => $this->users->newUsersCount(),
    		'banned' => $this->users->countByStatus(UserStatus::BANNED),
    		'unconfirmed' => $this->users->countByStatus(UserStatus::UNCONFIRMED)
    	];

    	$latestRegistrations = $this->users->latest(7);

    	return view('metrics.index', compact('stats', 'latestRegistrations', 'usersPerMonth'));
    }

 
}
