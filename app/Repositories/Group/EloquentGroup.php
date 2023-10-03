<?php

namespace Vanguard\Repositories\Group;

use Vanguard\Group;
use Carbon\Carbon;
use DB;
use Illuminate\Database\SQLiteConnection;

class EloquentGroup implements GroupRepository
{


    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
    	return Group::find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
    	return Group::create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function paginate($perPage, $search = null, $status = null)
    {
    	$query = Group::query();

    	if ($status) {
    		$query->where('status', $status);
    	}

    	if ($search) {
    		$query->where(function ($q) use ($search) {
    			$q->where('group', "like", "%{$search}%");
    			$q->orWhere('type', "like", "%{$search}%");
    			$q->orWhere('home', "like", "%{$search}%");
    		});
    	}

    	$result = $query
    	->sortable()
    	->orderBy('group', 'asc')
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

    	$group = $this->find($id);

    	$group->update($data);

    	return $group;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
    	$group = $this->find($id);

    	return $group->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
    	return Group::count();
    }

    /**
     * {@inheritdoc}
     */
    public function newGroupsCount()
    {
    	return Group::whereBetween('created_at', [Carbon::now()->firstOfMonth(), Carbon::now()])
    	->count();
    }

    /**
     * {@inheritdoc}
     */
    public function countByStatus($status)
    {
    	return Group::where('status', $status)->count();
    }

    /**
     * {@inheritdoc}
     */
    public function latest($count = 20)
    {
    	return Group::orderBy('created_at', 'DESC')
    	->limit($count)
    	->get();
    }

    /**
     * {@inheritdoc}
     */
    public function countOfNewGroupsPerMonth(Carbon $from, Carbon $to)
    {
    	$result = Group::whereBetween('created_at', [$from, $to])
    	->get(['created_at'])
    	->groupBy(function ($group) {
    		return $group->created_at->format("Y_n");
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
    public function lists($column = 'group', $key = 'id')
    {
        return Group::pluck($column, $column);
    }

}
