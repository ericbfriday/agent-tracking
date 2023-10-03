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
use Vanguard\Handler;

class ActiveHandlersController extends Controller
{
    
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('permission:handlers.manage');
	}

	public function index()
	{
        
		$handlers = Handler::where('status', 'Active')
		->orderBy('name', 'desc')
		->get();

		return view('handler.active-handlers', compact('handlers'));   
	} 
}
