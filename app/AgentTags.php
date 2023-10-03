<?php

namespace Vanguard;

use Illuminate\Notifications\Notifiable;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class AgentTags extends Model
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
    protected $table = 'agent_tags';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'id', 'name', 'colour_tag', 'is_hidden'
    ];

    public $sortable = ['id', 'name', 'colour_tag', 'is_hidden', 'created_at'];

    public function agent()
    {
        return $this->hasMany(AgentHasTags::class, 'agent_id');
    }

}
