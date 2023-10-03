<?php

namespace Vanguard;

use Illuminate\Notifications\Notifiable;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class AgentTimezones extends Model
{
    use 
	PresentableTrait,
	Notifiable,
    Sortable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'agent_timezones';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'id', 'name', 'colour_tag',
    ];

    public $sortable = ['id', 'name', 'colour_tag', 'created_at'];

    public function agent()
    {
        return $this->hasMany(AgentHasTimezones::class, 'agent_id');
    }
}
