<?php

namespace Vanguard\Repositories\Posts;

use Vanguard\Posts;
use Carbon\Carbon;
use DB;
use Illuminate\Database\SQLiteConnection;

class EloquentPosts implements PostsRepository
{


    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
    	return Posts::find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
    	return Posts::create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function paginate($perPage, $search = null)
    {
    	$query = Posts::query();

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

    	$post = $this->find($id);

    	$post->update($data);

    	return $post;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
    	$post = $this->find($id);

    	return $post->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
    	return Posts::count();
    }

    /**
     * {@inheritdoc}
     */
    public function newPostsCount()
    {
    	return Posts::whereBetween('created_at', [Carbon::now()->firstOfMonth(), Carbon::now()])
    	->count();
    }

    /**
     * {@inheritdoc}
     */
    public function latest($count = 20)
    {
    	return Posts::orderBy('created_at', 'desc')
    	->limit($count)
    	->get();
    }

    /**
     * {@inheritdoc}
     */
    public function countOfPostsPerMonth(Carbon $from, Carbon $to)
    {
    	$result = Posts::whereBetween('created_at', [$from, $to])
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
        return Posts::pluck($column, $column);
    }

}
