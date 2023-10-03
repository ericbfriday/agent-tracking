<?php

namespace Vanguard\Repositories\AgentTimezones;

use Vanguard\AgentTimezones;
use Carbon\Carbon;

class EloquentAgentTimezones implements AgentTimezonesRepository
{


    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
    	return AgentTimezones::find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
    	return AgentTimezones::create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function paginate($perPage, $search = null)
    {
    	$query = AgentTimezones::query();

    	if ($search) {
    		$query->where(function ($q) use ($search) {
    			$q->where('subject', "like", "%{$search}%");
                $q->orWhere('author', "like", "%{$search}%");
    		});
    	}

    	$result = $query
        ->sortable()
        ->orderBy('id', 'desc')
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

    	$tag = $this->find($id);

    	$tag->update($data);

    	return $tag;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
    	$tag = $this->find($id);

    	return $tag->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
    	return AgentTimezones::count();
    }

    /**
     * {@inheritdoc}
     */
    public function newAgentTimezonesCount()
    {
    	return AgentTimezones::whereBetween('created_at', [Carbon::now()->firstOfMonth(), Carbon::now()])
    	->count();
    }

    /**
     * {@inheritdoc}
     */
    public function latest($count = 20)
    {
    	return AgentTimezones::orderBy('created_at', 'desc')
    	->limit($count)
    	->get();
    }

    /**
     * {@inheritdoc}
     */
    public function countOfAgentTimezonesPerMonth(Carbon $from, Carbon $to)
    {
    	$result = AgentTimezones::whereBetween('created_at', [$from, $to])
    	->get(['created_at'])
    	->groupBy(function ($SpymasterPosts) {
    		return $SpymasterPosts->created_at->format("Y_n");
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
    public function lists($column = 'subject', $key = 'id')
    {
        return AgentTimezones::pluck($column, $column);
    }

}
