<?php

namespace Vanguard\Repositories\Agent;

use Vanguard\Agent;
use Carbon\Carbon;
use DB;
use Illuminate\Database\SQLiteConnection;

class EloquentAgent implements AgentRepository
{


    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
    	return Agent::find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
    	return Agent::create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function paginate($perPage, $search = null, $status = null)
    {
    	$query = Agent::query()->sortable();

    	if ($status) {
    		$query->where('status', $status);
    	}

    	if ($search) {
    		$query->where(function ($q) use ($search) {
    			$q->where('name', "like", "%{$search}%");
    			$q->orWhere('handler', "like", "%{$search}%");
    			$q->orWhere('group', "like", "%{$search}%");
    			$q->orWhere('logger_id', "like", "%{$search}%");
    			$q->orWhere('bh_forum_name', "like", "%{$search}%");
    			$q->orWhere('discord_name', "like", "%{$search}%");
    		});
    	}

    	$result = $query
        ->sortable()
        ->orderBy('name', 'asc')
        ->with('tags.tag')
    	->paginate($perPage);

    	if ($search) {
    		$result->appends(['search' => $search]);
    	}

    	return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, array $data)
    {

    	$agent = $this->find($id);

    	$agent->update($data);

    	return $agent;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
    	$agent = $this->find($id);

    	return $agent->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
    	return Agent::count();
    }

    /**
     * {@inheritdoc}
     */
    public function newAgentsCount()
    {
    	return Agent::whereBetween('created_at', [Carbon::now()->firstOfMonth(), Carbon::now()])
    	->count();
    }

    /**
     * {@inheritdoc}
     */
    public function countByStatus($status)
    {
    	return Agent::where('status', $status)->count();
    }

        /**
     * {@inheritdoc}
     */
    public function countActiveRelays()
    {
    	return Agent::where('logger_active', 'Active')->count();
    }

    /**
     * {@inheritdoc}
     */
    public function latest($count = 20)
    {
    	return Agent::orderBy('created_at', 'DESC')
    	->limit($count)
    	->get();
    }

    /**
     * {@inheritdoc}
     */
    public function countOfNewAgentsPerMonth(Carbon $from, Carbon $to)
    {
    	$result = Agent::whereBetween('created_at', [$from, $to])
    	->get(['created_at'])
    	->groupBy(function ($Agent) {
    		return $Agent->created_at->format("Y_n");
    	});

    	$counts = [];

    	while ($from->lt($to)) {
    		$key = $from->format("Y_n");

    		$counts[$this->parseDate($key)] = count($result->get($key, []));

    		$from->addMonth();
    	}

    	return $counts;
    }


    /**
     * Parse date from "Y_m" format to "{Month Name} {Year}" format.
     * @param $yearMonth
     * @return string
     */
    private function parseDate($yearMonth)
    {
    	list($year, $month) = explode("_", $yearMonth);

    	$month = trans("app.months.{$month}");

    	return "{$month} {$year}";
    }

     /**
     * {@inheritdoc}
     */
     public function lists($column = 'name', $key = 'id')
     {
     	return Agent::pluck($column, $column);
     }

 }
