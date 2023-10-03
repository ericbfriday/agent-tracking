<?php

namespace Vanguard\Repositories\AgentNotes;

use Vanguard\AgentNotes;
use Carbon\Carbon;
use DB;
use Illuminate\Database\SQLiteConnection;

class EloquentAgentNotes implements AgentNotesRepository
{


    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
    	return AgentNotes::find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
    	return AgentNotes::create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function paginate($perPage, $search = null, $category = null, $priority = null, $agents = null, $handlers = null, $owner = null)
    {
    	$query = AgentNotes::query();

    	if ($category) {
    		$query->where('category', $category);
    	}
    	
    	if ($priority) {
    		$query->where('priority', $priority);
    	}

    	if ($handlers) {
    		$query->where('handler', $handlers);
    	}

    	if ($agents) {
    		$query->where('agent', $agents);
    	}

    	if ($owner) {
    		$query->where('owner', $owner);
    	}

    	if ($search) {
    		$query->where(function ($q) use ($search) {
    			$q->where('subject', "like", "%{$search}%");
    		});
    	}

    	$result = $query
        ->sortable()
        ->orderBy('created_at', 'desc')
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

    	$agentNotes = $this->find($id);

    	$agentNotes->update($data);

    	return $agentNotes;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
    	$agentNotes = $this->find($id);

    	return $agentNotes->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
    	return AgentNotes::count();
    }

    /**
     * {@inheritdoc}
     */
    public function newAgentNotessCount()
    {
    	return AgentNotes::whereBetween('created_at', [Carbon::now()->firstOfMonth(), Carbon::now()])
    	->count();
    }

    /**
     * {@inheritdoc}
     */
    public function countByStatus($status)
    {
    	return AgentNotes::where('status', $status)->count();
    }

    /**
     * {@inheritdoc}
     */
    public function latest($count = 20)
    {
    	return AgentNotes::orderBy('created_at', 'DESC')
    	->limit($count)
    	->get();
    }

    /**
     * {@inheritdoc}
     */
    public function countOfNewAgentNotessPerMonth(Carbon $from, Carbon $to)
    {
    	$result = AgentNotes::whereBetween('created_at', [$from, $to])
    	->get(['created_at'])
    	->AgentNotesBy(function ($agentNotes) {
    		return $agentNotes->created_at->format("Y_n");
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
    public function lists($column = 'agent', $key = 'id')
    {
    	return AgentNotes::pluck($column, $column);
    }
}
