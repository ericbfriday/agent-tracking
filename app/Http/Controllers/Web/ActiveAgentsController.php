<?php

/*
 * Goonswarm Federation - Black Hand Tools
 *
 * Developed by scopehone <scopeh@gmail.com>
 * In conjuction with Izzy, such a hard customer! 
 *
 */

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Agent;

class ActiveAgentsController extends Controller
{
	public function __construct()
	{
       
		$this->middleware('auth');
		$this->middleware('permission:agents.manage');
	}

	public function index()
	{
       
		$agents = Agent::where('status', 'Active')
		->orderBy('name', 'asc')
		->get();

		return view('agent.active-agents', compact('agents'));   
	} 
}
