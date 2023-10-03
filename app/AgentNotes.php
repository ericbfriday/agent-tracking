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
use Vanguard\Presenters\AgentNotesPresenter;
use Vanguard\Support\Authorization\AuthorizationUserTrait;
use Vanguard\Support\Enum\AgentStatus;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class AgentNotes extends Model
{
     use 
	PresentableTrait,
	Notifiable,
    Sortable;

	protected $presenter = AgentNotesPresenter::class;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'agent_notes';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'agent', 'handler', 'owner', 'subject', 'notes', 'notify_handler', 'notify_spymaster', 'priority', 'category'
    ];

    public $sortable = ['agent', 'handler', 'owner', 'subject', 'notes', 'notify_handler', 'notify_spymaster', 'priority', 'category', 'created_at'];
}
