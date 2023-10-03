<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class AgentHasTag extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'agent_has_tags';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    public function tag()
    {
        return $this->hasOne(AgentTags::class, 'id', 'tag_id');
    }

    public function agent()
    {
        return $this->hasOne(Agent::class, 'id', 'agent_id');
    }

    public function agents()
    {
        return $this->hasMany(Agent::class, 'id', 'agent_id');
    }

}
