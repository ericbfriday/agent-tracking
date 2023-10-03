<?php

/*
 * Goonswarm Federation - Black Hand Tools
 *
 * Developed by scopehone <scopeh@gmail.com>
 * In conjuction with Izzy, such a hard customer! 
 *
 */

namespace Vanguard;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Vanguard\Presenters\NotificationsPresenter;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class ContactNotifications extends Model
{

    use 
    PresentableTrait,
    Notifiable,
    Sortable;

    protected $presenter = NotificationsPresenter::class;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'contact_note_notifications';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'note_id', 'to', 'from', 'acknowledged'
    ];

    public $sortable = ['note_id', 'to', 'from', 'acknowledged'];


}
