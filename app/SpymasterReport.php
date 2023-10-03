<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class SpymasterReport extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'spymaster_reports';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'id', 
        'start_date',
        'end_date',
        'week_number',
        'month',
        'year',
        'report_type',
        'status',
        'active_agents',
        'active_handlers',
        'active_groups',
        'report_data',
    ];
}
