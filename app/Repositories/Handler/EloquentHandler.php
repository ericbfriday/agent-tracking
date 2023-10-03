<?php

namespace Vanguard\Repositories\Handler;

use Vanguard\Handler;
use Carbon\Carbon;
use DB;
use Illuminate\Database\SQLiteConnection;

class EloquentHandler implements HandlerRepository
{


    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
    	return Handler::find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
    	return Handler::create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function paginate($perPage, $search = null, $status = null)
    {
    	$query = Handler::query();

    	if ($status) {
    		$query->where('status', $status);
    	}

    	if ($search) {
    		$query->where(function ($q) use ($search) {
    			$q->where('name', "like", "%{$search}%");
    			$q->orWhere('timezone', "like", "%{$search}%");
    		});
    	}

    	$result = $query
    	->sortable()
    	->orderBy('name', 'asc')
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

    	$handler = $this->find($id);

    	$handler->update($data);

    	return $handler;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
    	$handler = $this->find($id);

    	return $handler->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
    	return Handler::count();
    }

    /**
     * {@inheritdoc}
     */
    public function newHandlersCount()
    {
    	return Handler::whereBetween('created_at', [Carbon::now()->firstOfMonth(), Carbon::now()])
    	->count();
    }

    /**
     * {@inheritdoc}
     */
    public function countByStatus($status)
    {
    	return Handler::where('status', $status)->count();
    }

    /**
     * {@inheritdoc}
     */
    public function latest($count = 20)
    {
    	return Handler::orderBy('created_at', 'DESC')
    	->limit($count)
    	->get();
    }

    /**
     * {@inheritdoc}
     */
    public function countOfNewHandlersPerMonth(Carbon $from, Carbon $to)
    {
    	$result = Handler::whereBetween('created_at', [$from, $to])
    	->get(['created_at'])
    	->groupBy(function ($handler) {
    		return $handler->created_at->format("Y_n");
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
        	return Handler::pluck($column, $column);
        }
    }
