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
use Vanguard\Presenters\AgentPresenter;
use Vanguard\Support\Authorization\AuthorizationUserTrait;
use Vanguard\Support\Enum\AgentStatus;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Agent extends Model
{
    use 
	PresentableTrait,
	Notifiable,
    Sortable;


	protected $presenter = AgentPresenter::class;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'agents';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'name', 'handler', 'notes', 'group', 'status', 'owner', 'logger_active', 'logger_id', 'jabber_name', 'skype_name', 'discord_name', 'timezone', 'bh_forum_name', 'gsf_forum_name', 'main_character_name', 'main_character_corporation', 'main_character_alliance', 'confirm_relay', 'recieved_training_manual', 'completed_questionaire'
    ];

    public $sortable = ['name', 'handler', 'notes', 'group', 'status', 'owner', 'logger_active', 'logger_id', 'jabber_name', 'skype_name', 'discord_name', 'timezone', 'bh_forum_name', 'gsf_forum_name', 'main_character_name', 'main_character_corporation', 'main_character_alliance', 'confirm_relay', 'recieved_training_manual', 'completed_questionaire', 'updated_at'];

    public function isInactive()
    {
    	return $this->status == AgentStatus::INACTIVE;
    }

    public function isActive()
    {
    	return $this->status == AgentStatus::ACTIVE;
    }

    public function tags()
    {
        return $this->hasMany(AgentHasTag::class, 'agent_id');
    }

    public function groups()
    {
        return $this->hasMany(AgentHasGroup::class, 'agent_id');
    }

    public function timezones()
    {
        return $this->hasMany(AgentHasTimezones::class, 'agent_id');
    }

}
