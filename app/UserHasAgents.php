<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class UserHasAgents extends Model
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

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function agent()
    {
        return $this->hasOne(Agent::class, 'id', 'agent_id');
    }
}
