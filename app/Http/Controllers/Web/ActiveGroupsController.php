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
use Vanguard\Group;

class ActiveGroupsController extends Controller
{
	public function __construct()
	{
     
		$this->middleware('auth');
		$this->middleware('permission:groups.manage');
	}

	public function index()
	{
		$groups = Group::where('status', 'Active')
		->orderBy('group', 'asc')
		->sortable()
		->get();

		return view('group.active-groups', compact('groups'));   
	}
}
