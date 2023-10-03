<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class AgentHasTimezones extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'agent_has_timezones';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    public function timezone()
    {
        return $this->hasOne(AgentTimezones::class, 'id', 'timezone_id');
    }

    public function agent()
    {
        return $this->hasOne(Agent::class, 'id', 'agent_id');
    }
}
