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
use Vanguard\Presenters\HandlerPresenter;
use Vanguard\Support\Authorization\AuthorizationUserTrait;
use Vanguard\Support\Enum\HandlerStatus;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Handler extends Model
{
	use 
	PresentableTrait,
	Notifiable,
    Sortable;

	protected $presenter = HandlerPresenter::class;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'handlers';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'name', 'gsf_forum_name', 'skype_name', 'discord_name', 'timezone', 'status', 'notes', 'owner'
    ];

    public $sortable = ['name', 'gsf_forum_name', 'skype_name', 'discord_name', 'timezone', 'status', 'notes', 'owner'];


    public function isInactive()
    {
    	return $this->status == HandlerStatus::INACTIVE;
    }

    public function isActive()
    {
    	return $this->status == HandlerStatus::ACTIVE;
    }
}
