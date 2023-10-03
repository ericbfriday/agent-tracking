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
use Auth;
use Carbon\Carbon;
use Vanguard\Posts;

use Vanguard\ContactNotifications;

class ContactNotificationsController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');

	}

	public function acknowledgeNotification($id) {

    	// Does this notification below to you.

		$belongsToMe = ContactNotifications::where('id', $id)
		->where('to', Auth::id())
		->first();

		if(isset($belongsToMe)) {

			$ContactNotifications = ContactNotifications::where('id', $id)
			->update(['acknowledged' => 1]);

			return redirect()->route('dashboard')
			->withSuccess('Notification Acknowledged and Archived.');

		} else {

			return redirect()->route('dashboard')
			->withErrors('This Notification does not belong to you.');


		}

	}

	public function index()
	{

		$notifications = Posts::orderBy('created_at', 'DESC')
		->paginate(20);


		return view('notifications.index', compact('notifications'));


	}


}

