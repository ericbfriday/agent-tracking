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
use Vanguard\Support\Enum\UserStatus;
use Auth;
use Vanguard\Posts;
use Carbon\Carbon;

use Vanguard\ContactNotifications;

class DashboardController extends Controller
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
     * DashboardController constructor.
     * @param UserRepository $users
     * @param ActivityRepository $activities
     */
    public function __construct(UserRepository $users, ActivityRepository $activities)
    {
    	$this->middleware('auth');
    	$this->users = $users;
    	$this->activities = $activities;
    }

    /**
     * Displays dashboard based on user's role.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
    	if (Auth::user()->hasRole('Admin')) {
    		return $this->adminDashboard();
    	}

    	return $this->defaultDashboard();
    }

    /**
     * Displays dashboard for admin users.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function adminDashboard()
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

    	return view('dashboard.admin', compact('stats', 'latestRegistrations', 'usersPerMonth'));
    }

    /**
     * Displays default dashboard for non-admin users.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function defaultDashboard()
    {

    	$user = Auth::user();
    	$owner = $user->username;

    	$activities = $this->activities->userActivityForPeriod(
    		Auth::user()->id,
    		Carbon::now()->subWeeks(2),
    		Carbon::now()
    	)->toArray();

    	$ContactNotifications = ContactNotifications::where('to', Auth::id())
        ->where('acknowledged',  '0')
    	->paginate(5);

    	$posts = Posts::orderBy('created_at' , 'DESC')
    	->paginate(6);

    	$ContactNotificationsCount =  ContactNotifications::where('to', Auth::id())
    	->where('acknowledged',  '0')
    	->count();

 
    	return view('dashboard.default', compact('activities', 'ContactNotifications', 'posts', 'ContactNotificationsCount'));
    }

        /**
     * Displays default dashboard for non-admin users.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function help()
    {
    	return view('help.index');
    }


}
