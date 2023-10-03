<?php

/*
 * Goonswarm Federation - Black Hand Tools
 *
 * Developed by scopehone <scopeh@gmail.com>
 * In conjuction with Izzy, such a hard customer! 
 *
 */

namespace Vanguard\Http\Controllers\Web;

use Vanguard\Events\Handler\UpdatedByAdmin;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Requests\Handler\CreateHandlerRequest;
use Vanguard\Http\Requests\Handler\UpdateDetailsRequest;
use Vanguard\Http\Requests\Handler\UpdateLoginDetailsRequest;
use Vanguard\Repositories\Handler\HandlerRepository;
use Vanguard\Repositories\Group\GroupRepository;
use Vanguard\Repositories\User\UserRepository;
use Vanguard\Support\Enum\HandlerStatus;
use Vanguard\Support\Enum\TimeZones;
use Vanguard\Handler;
use Vanguard\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use Auth;

class HandlersController extends Controller
{
     /**
     * @var HandlersRepository
     */
     private $handlers;

    /**
     * HandlersController constructor.
     * @param HandlersRepository $handlers
     */
    public function __construct(HandlerRepository $handlers)
    {
    	$this->middleware('auth');
    	$this->handlers = $handlers;
    }

    /**
     * Display paginated list of all handlers.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {


        $user = Auth::user();
        $owner = $user->username;
        if (Auth::user()->hasRole('Spymaster')) {     


           $handlers = $this->handlers->paginate(
              $perPage = 50,
              Input::get('search'),
              Input::get('status')
          );

           $statuses = ['' => trans('app.all')] + HandlerStatus::lists();

           return view('handler.list', compact('handlers', 'statuses'));

       } else {
        return redirect()->route('handler.mine')
        ->withErrors('You do not have permission to view handlers that do not belong to you.');

    }
}


    /**
     * Displays form for creating a new handler.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(GroupRepository $groupRepository, UserRepository $UserRepository)
    {
    	$statuses = HandlerStatus::lists();
    	$timezones = TimeZones::lists();
    	$users = $UserRepository->lists();
    	$groups = $groupRepository->lists();

    	return view('handler.add', compact('statuses', 'groups', 'timezones', 'users'));
    }


    /**
     * Stores new handler into the database.
     *
     * @param CreatehandlerRequest $request
     * @return mixed
     */
    public function store(CreateHandlerRequest $request)
    {
        // When handler is created by administrator, we will set his
        // status to Active by default.
    	$data = $request->all();

    	$handler = $this->handlers->create($data);

    	return redirect()->route('handler.list')
    	->withSuccess(trans('app.handler_created'));
    }

    /**
     * Displays handler profile page.
     *
     * @param handler $handler
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
        public function view(Handler $handler)
        {


            $user = Auth::user();
            $owner = $user->username;
            $agents = Agent::where('handler', $handler->name)
            ->orderBy('status', 'asc')
            ->get();

            if (Auth::user()->hasRole('Spymaster')) {
                return view('handler.view', compact('handler', 'agents'));
            }

            if($handler->owner == $owner) {
                return view('handler.view', compact('handler', 'agents'));

            } else {
                return redirect()->route('handler.mine')
                ->withErrors('This handler does not belong to you.');
            }


        }

    /**
     * Displays edit handler form.
     *
     * @param handler $handler
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Handler $handler, GroupRepository $groupRepository, UserRepository $UserRepository)
    {


        $user = Auth::user();
        $owner = $user->username;

        if (Auth::user()->hasRole('Spymaster')) {



            $edit = true;
            $statuses = HandlerStatus::lists();
            $groups = $groupRepository->lists();
            $users = $UserRepository->lists();
            $timezones = TimeZones::lists();

            return view(
              'handler.edit',
              compact('edit', 'handler', 'statuses', 'groups', 'timezones', 'users')
          );

        } else {

            return redirect()->route('handler.mine')
            ->withErrors('You do not have permission to edit.');

        }


    }


    /**
     * Updates handler details.
     *
     * @param handler $handler
     * @param UpdateDetailsRequest $request
     * @return mixed
     */
    public function updateDetails(Handler $handler, UpdateDetailsRequest $request)
    {
    	$data = $request->all();

    	$this->handlers->update($handler->id, $data);

    	event(new UpdatedByAdmin($handler));

    	return redirect()->route('handler.show', $handler->id)
    	->withSuccess('Handler ' . $handler->name . ' Updated');
    }


    /**
     * Displays my handlers.
     *
     * @param Agent $agent
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function myHandlers()
    {

    	$user = Auth::user();
    	$owner = $user->username;
    	$handlers = Handler::where('owner', $owner)
    	->get();

    	return view('handler.mine', compact('handlers'));
    }


    /**
     * Displays my handlers.
     *
     * @param Agent $agent
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function myActiveHandlers()
    {

        $user = Auth::user();
        $owner = $user->username;
        $handlers = Handler::where('owner', $owner)
        ->where('status', 'Active')
        ->get();

        return view('handler.mine-active', compact('handlers'));
    }

    /**
     * Displays my handlers.
     *
     * @param Agent $agent
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function myInactiveHandlers()
    {

        $user = Auth::user();
        $owner = $user->username;
        $handlers = Handler::where('owner', $owner)
        ->where('status', 'Inactive')
        ->get();

        return view('handler.mine-inactive', compact('handlers'));
    }

    public function countAgents($handler) {

        $agents = Agents::where('handler', $handler) 
        ->count();
       

        return $agents;

    }



}
