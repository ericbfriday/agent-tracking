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
use Vanguard\Presenters\GroupPresenter;
use Vanguard\Support\Authorization\AuthorizationUserTrait;
use Vanguard\Support\Enum\GroupStatus;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Group extends Model
{
	
	use 
	PresentableTrait,
	Notifiable,
    Sortable;

	protected $presenter = GroupPresenter::class;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'groups';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'group', 'type', 'home', 'notes', 'status', 'topsecret', 'is_hidden', 'colour_tag'
    ];

    public $sortable = ['group', 'type', 'home', 'notes', 'status', 'topsecret', 'is_hidden', 'colour_tag', 'updated_at'];


    public function isUnconfirmed()
    {
    	return $this->status == GroupStatus::UNCONFIRMED;
    }

    public function isActive()
    {
    	return $this->status == GroupStatus::ACTIVE;
    }

}


