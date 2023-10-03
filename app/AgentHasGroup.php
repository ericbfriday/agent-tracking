<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class AgentHasGroup extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'agent_has_groups';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    public function group()
    {
        return $this->hasOne(Group::class, 'id', 'group_id');
    }

    public function agent()
    {
        return $this->hasOne(Agent::class, 'id', 'agent_id');
    }
}
