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
use Auth;

class MyHandlersController extends Controller
{
    	public function index()
	{
		
		$owner = Auth::user();

		$handlers = Handler::where('owner', $owner->username)
		->orderBy('name', 'asc')
		->get();
		return view('handler.my-handlers', compact('handlers'));   

	}
}
